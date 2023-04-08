<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientsModel;
use App\Models\User;

class Dogovor extends Model
{
    use HasFactory;

    public function userFunc()
    {
        return $this->belongsTo(USER::class, 'lawyer_id', 'id');
    }

    public function clientFunc()
    {
        return $this->belongsTo(ClientsModel::class, 'client_id', 'id');
    }
}
