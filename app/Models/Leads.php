<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tasks;
use Illuminate\Http\Client\Request;

class Leads extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'description', 'source',
        'service', 'lawyer', 'responsible', 'status'
    ];

    /** Создание лида по API сервиса Мои звонки */
    public function newFromServiceMyCalls(Request $request)
    {
        $lead = new self();
       $lead->name = $request->input('name');
       $lead->phone = $request->input('phone');
       $lead->description = $request->input('description');
       $lead->source = $request->input('source');
       $lead->service = $request->input('service');
       $lead->lawyer = $request->input('lawyer');
       $lead->responsible = $request->input('responsible');
       $lead->status = $request->input('status');
       $lead->save();
    }

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
