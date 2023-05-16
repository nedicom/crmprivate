<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;

class Leads extends Model
{
    use HasFactory;

    public function userFunc()
    {
        return $this->belongsTo(User::class, 'lawyer');
    }

    public function responsibleFunc()
    {
        return $this->belongsTo(User::class, 'responsible');
    }

    public function servicesFunc()
    {
        return $this->belongsTo(Services::class, 'service');
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'lead_id', 'id');
    }
}
