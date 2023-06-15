<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Payments extends Model
{
    use HasFactory;

    public function serviceFunc()
    {
        return $this->belongsTo(Services::class, 'service');
    }

    public function AttractionerFunc()
    {
        return $this->belongsTo(User::class, 'nameOfAttractioner');
    }

    public function sellerFunc()
    {
        return $this->belongsTo(User::class, 'nameOfSeller');
    }

    public function developmentFunc()
    {
        return $this->belongsTo(User::class, 'directionDevelopment');
    }

    public function tasks()
    {
        return $this->belongsToMany(Tasks::class, 'task_payment_assigns', 'payment_id', 'task_id');
    }
}
