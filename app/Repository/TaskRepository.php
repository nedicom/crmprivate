<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Tasks;

class TaskRepository
{
    /**
     * Скалярное значение кол-ва задач по статусу для авторизованного пользователя
     * @return int
     */
    public function countByStatusForAuth(string $status = Tasks::STATUS_IN_WORK): int
    {
        return DB::table('tasks')->where('lawyer', '=', Auth::id())->where('status', '=', $status)->count();
    }

    /**
     * Выборка записей по интервалу даты
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @param array $fields
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByBetweenDate(\Carbon\Carbon $startDate, \Carbon\Carbon $endDate, array $fields)
    {
        $query = Tasks::select("*")
            ->whereBetween('date', [$startDate, $endDate]) // variable were using
            ->where($fields['lawyerfilter'], '=', $fields['checkedlawyer'])
            ->where($fields['typefilter'], '=', $fields['type'])
            ->orderBy('date', 'asc')
            ->get();

        return $query;
    }

    /**
     * Коллекция всех задач в диапазоне ограничения
     * @param array $fields
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(array $fields)
    {
        $query = Tasks::select("*")
            ->where($fields['lawyerfilter'], '=', $fields['checkedlawyer'])
            ->where($fields['typefilter'], '=', $fields['type'])
            ->orderBy('date', 'asc')
            ->get();

        return $query;
    }
}
