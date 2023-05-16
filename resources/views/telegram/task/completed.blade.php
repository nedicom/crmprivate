<?php
/**
 * @var \App\Models\Tasks $task
 * @var \App\Models\User $user
 */
?>
Задача <b>{{ $task->name }}</b> выполнена. Исполнитель: {{ $user?->name }}.

<a href="{{ route('showTaskById', $task->id) }}">{{ route('showTaskById', $task->id) }}</a>

