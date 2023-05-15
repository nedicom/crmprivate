<?php

namespace App\Helpers;

use App\Models\Tasks;
use App\Repository\TaskRepository;

class TaskHelper
{
    /**
     * Кол-во задач по значению статуса
     * @param string $status
     * @return int
     */
    public static function countTasksByStatus(string $status = Tasks::STATUS_IN_WORK): int
    {
        $repository = new TaskRepository();

        return $repository->countByStatusForAuth($status);
    }
}
