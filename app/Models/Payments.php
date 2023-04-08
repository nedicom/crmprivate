<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Services;
use App\Models\User;
use App\Models\ClientsModel;

class Payments extends Model
  {
      use HasFactory;

        public function serviceFunc(){
        return $this->belongsTo(Services::class, 'service');
    }

        public function AttractionerFunc(){
        return $this->belongsTo(USER::class, 'nameOfAttractioner');
    }

        public function sellerFunc(){
        return $this->belongsTo(USER::class, 'nameOfSeller');
    }

        public function developmentFunc(){
        return $this->belongsTo(USER::class, 'directionDevelopment');
    }
  }
