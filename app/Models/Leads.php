<?php

namespace App\Models;

use App\Models\Services;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;

    public function userFunc(){
        return $this->belongsTo(USER::class, 'lawyer');
    }

    public function responsibleFunc(){
        return $this->belongsTo(USER::class, 'responsible');
    }

    public function servicesFunc(){
        return $this->belongsTo(Services::class, 'service');
    }
}
