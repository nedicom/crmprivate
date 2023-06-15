<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class PaymentRepository
{
    /**
     * Список платажей по search запросу имени клиента
     * @param string  $clientName Имя клиента
     * @return mixed
     */
    public function getByClientQuery(string $clientName)
    {
        $query = DB::table('payments')
            ->select(['payments.id', 'payments.client', 'payments.created_at', 'services.name AS service_name'])
            ->join('services', 'payments.service', '=', 'services.id')
            ->where('payments.client', 'LIKE', '%' . $clientName . '%')
            ->get();

        return $query;
    }
}
