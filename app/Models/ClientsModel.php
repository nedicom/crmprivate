<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Tasks;
use App\Models\Payments;
use App\Models\Services;

  class ClientsModel extends Model
  {

    use HasFactory;

    public function userFunc()
      {
          return $this->belongsTo(USER::class, 'lawyer');
      }

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

  }
