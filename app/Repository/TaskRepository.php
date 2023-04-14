<?php

namespace App\Repository;

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
}
