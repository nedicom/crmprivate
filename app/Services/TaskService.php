<?php

namespace App\Services;

use App\Models\TaskPaymentAssign;
use App\Models\Tasks;

class TaskService
{
    /**
     * Генерируем выпадающий список дел
     * @return void
     */
    public function generateListDeals()
    {
    }

    /**
     * Присваевываем добавленные платежи
     * @param Tasks $task
     * @param array $input
     * @return void
     */
    public function assignPayments(Tasks $task, array $input): void
    {
        foreach ($input as $key => $value) {
            if (!empty($value)) {
                TaskPaymentAssign::create(['payment_id' => $value, 'task_id' => $task->id]);
            }
        }
    }

    /**
     * Удаляем присвоенные платежи
     * @param Tasks $task
     * @return void
     */
    public function clearAssignPayments(Tasks $task): void
    {
        $payments = $task->payments();
        if ($payments->count() > 0) {
            foreach ($payments->get() as $payment) {
                $payment->pivot->delete();
            }
        }
    }
}
