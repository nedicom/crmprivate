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

    /**
     * Форматирование знсчения продолжительности в массив часы, минуты
     * @param $duration
     * @param string $type тип значения
     * @return int[]
     */
    public static function transformDuration($duration, string $type = 'old'): array
    {
        $str_time = ['hours' => 0, 'minutes' => 0];

        if ($duration !== 0 && $type === Tasks::TYPE_DURATION_OLD) {
            if (is_double($duration) && preg_match('/^[0-9]+[,.][0-9]*$/', $duration)) {
                // Обработка дробного числа
                $res = explode('.', $duration);
                $hour = ($res[0] !== 0) ? $res[0] * 60 : 0;
                $minutes = ($res[1] !== 0) ? $res[1] * 6 : 0;
                $time = $hour + $minutes;

                $str_time['hours'] = intval($time / 60);
                $str_time['minutes'] = $time % 60;
            } else if (is_double($duration) && !preg_match('/^[0-9]+[,.][0-9]*$/', $duration)) {
                $str_time['hours'] = $duration;
                $str_time['minutes'] = 0;
            } else if (is_int($duration) && $type == Tasks::TYPE_DURATION_OLD) {
                $str_time['hours'] = $duration;
                $str_time['minutes'] = 0;
            } else if (is_int($duration) && $type == Tasks::TYPE_DURATION_NEW) {
                $str_time['hours'] = intval($duration / 60);
                $str_time['minutes'] = $duration % 60;
            }
        } else if ($duration !== 0 && $type === Tasks::TYPE_DURATION_NEW) {
            $str_time['hours'] = intval($duration / 60);
            $str_time['minutes'] = $duration % 60;
        }

       return $str_time;
    }
}
