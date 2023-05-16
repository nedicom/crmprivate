<?php
/**
 * @var \App\Models\Tasks $task
 * @var \App\Models\User $user
 */
?>
Новая задача <b>{{ $task->name }}</b>. Постановщик: {{ $user?->name }}.

<a href="{{ route('showTaskById', $task->id) }}">{{ route('showTaskById', $task->id) }}</a>

