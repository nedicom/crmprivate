<?php

namespace App\Helpers;

use App\Models\Tasks;
use App\Repository\TaskRepository;
use App\Models\Enums\Tasks\Type;
use App\Models\Enums\Tasks\Status;

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

    /**
     * Стиль элемента в зависимости от типа Задачи
     * @param string $type
     * @return string
     */
    public static function typeStyle(string $type): string
    {
        return match ($type) {
            Type::Control->value => 'border:3px solid #bfbffc; background-color: lavender;',
            Type::Sending->value => 'border: 2px solid #57ec00; background-color: #d1ffb6;',
            default => '',
        };
    }

    /**
     * Ширина сайдбара в зависимости от статуса Задачи
     * @param string $status
     * @return string
     */
    public static function widthSidebarByStatus(string $status): string
    {
        return match ($status) {
            Status::WAITING->value => 'width: 50%;',
            Status::IN_WORK->value => 'width: 75%',
            Status::OVERDUE->value => 'width: 25%;',
            Status::COMPLETE->value => 'width: 100%;',
            default => 'width: 100%',
        };
    }
}
