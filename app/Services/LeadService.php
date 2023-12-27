<?php

namespace App\Services;

use App\Helpers\UserHelper;
use App\Services\MyCalls\ValueObject\RingDTO;
use Illuminate\Support\Facades\DB;
use App\Models\Leads;
use App\Models\ClientsModel;

class LeadService
{
    const CLIENTS_TABLE_NAME = 'clients_models';
    const LEAD_TABLE_NAME = 'leads';

    /** Обработчик вебхука call.finish из API сервиса Мои звонки
     * @param RingDTO $valueObject
     */
    public function handleWebhookFinished(RingDTO $valueObject): void
    {
        $clientName = (!empty($valueObject->getClientName())) ? $valueObject->getClientName() : 'Имя не указано';

        if (($id = $this->checkExistsPhone($valueObject->getFormatClientPhone(),static::CLIENTS_TABLE_NAME)) !== null) {
            /** @var ClientsModel $client */
            $client = ClientsModel::find($id);
            $clientName = $client->name;
            $source = 'существующий клиент';
        } elseif ($this->checkExistsPhone($valueObject->getFormatClientPhone(),static::LEAD_TABLE_NAME)) {
            $source = 'Повторный лид';
        } else {
            // Если поиск по телефону не дал результатов
            $source = ($valueObject->getOwnerPhone() == '+79788838978' || $valueObject->getOwnerPhone() == '+79784731847')
                ? $valueObject->getOwnerPhone()
                : 'не знаю источник';
        }

        $lead = Leads::newFromServiceMyCalls($valueObject, $clientName, $source);
        $lead->save();
    }

    /**
     * Поиск по существующему номеру в БД в таблицах clients_models и leads
     * @param string $currentPhone
     * @param string $tableName
     * @return int|null
     */
    private function checkExistsPhone(string $currentPhone, string $tableName): ?int
    {
        if (DB::table($tableName)->exists()) {
            $clientsPhones = DB::table($tableName)->orderBy('id','DESC')->pluck('phone', 'id')->toArray();
            $processPhones = UserHelper::formatPhone($clientsPhones);

            foreach ($processPhones as $id => $phone)
                if ($currentPhone === $phone)
                    return $id;
        } else {
            throw new \InvalidArgumentException('Таблицы с таким именем не существует в БД.');
        }

        return null;
    }
}
