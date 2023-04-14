<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Tasks extends Model
{
    const STATUS_WAITING = 'ожидает';
    const STATUS_OVERDUE = 'просрочена';
    const STATUS_IN_WORK = 'в работе';

    use HasFactory;

    protected $fillable = ['*'];

    protected function date(): Attribute
    {
        $weekMap = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четерг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье'];

        return Attribute::make(
            get: fn ($value) => [
                'value' => Carbon::parse($value)->format('Y-m-d H:i'),
                'day' => $weekMap[Carbon::parse($value)->dayOfWeekIso],
                'month' => Carbon::parse($value)->format('j'),
                'currentMonth' => Carbon::parse($value)->locale('ru_RU')->monthName,
                'currentTime' => Carbon::parse($value)->format('H:i'),
                'currentDay' => Carbon::parse($value)->format('j'),
                'currentHour' => Carbon::parse($value)->format('H'),
            ],
        );
    }

    /**
     * Получить дело
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id', 'id');
    }

    public function clientsModel()
    {
        return $this->belongsTo(ClientsModel::class, 'clientid', 'id');
    }
}
