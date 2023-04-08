<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Meetings extends Model
{
    use HasFactory;

    protected function date(): Attribute

      {$weekMap = [0 => 'Воскресенье', 1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четерг', 5 => 'Пятница', 6 => 'Суббота'];


            return Attribute::make(
                get: fn ($value) => [
                'value' => Carbon::parse($value)->format('Y-m-d H:i'),
                'day' => $weekMap[Carbon::parse($value)->dayOfWeekIso],
                'month' => Carbon::parse($value)->format('j'),
                'currentMonth' => Carbon::parse($value)->locale('ru_RU')->monthName,
                'currentTime' => Carbon::parse($value)->format('H:i'),
                'currentDay' => Carbon::parse($value)->format('j'),
              ],
            );

      }

}
