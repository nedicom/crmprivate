<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * int $task_id
 * int $payment_id
 */
class TaskPaymentAssign extends Model
{
    //protected $primaryKey = ['task_id', 'payment_id'];
    /**
     * Указывает, что идентификаторы модели являются автоинкрементными.
     * @var bool
     */
    //public $incrementing = false;
    protected $table = 'task_payment_assigns';
    public $timestamps = false;
    protected $guarded = [];
}
