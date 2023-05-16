<?php

namespace App\Listeners\Task\TaskCreated;

use App\Events\Task\TaskCreated;

class PushTaskGoogleCalendar
{
    /**
     * Отправка задачи в Google Calendar
     * @param TaskCreated $event
     * @return void
     */
    public function handle(TaskCreated $event)
    {
        $task = $event->task;
    }
}
