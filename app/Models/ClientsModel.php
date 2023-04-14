<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsModel extends Model
{
    use HasFactory;

    public function userFunc()
    {
        return $this->belongsTo(User::class, 'lawyer');
    }

    /**
     * Список задач Клиента
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasksFunc()
    {
        return $this->hasMany(Tasks::class, 'clientid' , 'id');
    }

    public function serviceFunc()
    {
        return $this->hasManyThrough(
            Services::class,
            Payments::class,
            'clientid',
            'id',
            'id',
            'service'
        );
    }

    public function paymentsFunc()
    {
        return $this->hasMany(Payments::class, 'clientid' , 'id');
    }

    /**
     * Список дел Клиента
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deals()
    {
        return $this->hasMany(Deal::class, 'client_id', 'id');
    }
}
