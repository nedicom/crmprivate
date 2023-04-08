<?php

namespace App\Console\Commands\Test;

use App\Events\Task\TaskCompleted;
use App\Events\Task\TaskCreated;
use App\Models\Tasks;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class TaskEvent extends Command
{
    protected $signature = 'test:task {id} {event}';

    protected $description = 'Тестирование проброса событий';

    public function handle(): int
    {
        $taskId = $this->argument('id');

        $task = Tasks::find($taskId);

        switch ($this->argument('event')) {
            case 'created':
                TaskCreated::dispatch($task);
                break;
            case 'completed':
                TaskCompleted::dispatch($task);
                break;
        }

        return CommandAlias::SUCCESS;
    }
}
