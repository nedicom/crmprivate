<?php

namespace App\Repository;

use App\Models\ClientsModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ClientRepository
{
    /**
     * Возвращение коллекции клиентов по статусу ('просрочена', 'в работе', 'ожидают') задач
     * @param $lawyertask
     * @param string|null $statusTask
     * @param string|null $checkedlawyer
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByStatusTasks($lawyertask, ?string $statusTask, ?string $checkedlawyer)
    {
        $query = ClientsModel::whereHas('tasksFunc', function (Builder $query) use ($lawyertask, $statusTask, $checkedlawyer) {
            $query->where('status', '=', $statusTask)
                ->where($checkedlawyer, '=',  $lawyertask);
        }, '>=', 1)->get();

        return $query;
    }

    /**
     * Возвращение коллекции клиентов по имени клиента и юриста
     * @param Request $request
     * @param string|null $checkedlawyer
     * @param $statusclient
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByClientAndLawyer(Request $request, ?string $checkedlawyer, $statusclient)
    {
        $query = ClientsModel::where('name', 'like', '%' . $request->findclient . '%')
            ->where($checkedlawyer, $request->checkedlawyer)
            ->where($statusclient, $request->status)
            ->get();

        return $query;
    }

    /**
     * Найти объект по его id
     * @param int $id
     * @return Builder
     */
    public function findById(int $id)
    {
        $query = ClientsModel::with('userFunc', 'tasksFunc', 'serviceFunc', 'paymentsFunc')->find($id);
        return $query;
    }
}
