<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * @property int $id
 * @property string $client
 * @property string $name
 * @property string $lawyer
 * @property string $date
 * @property string $status
 * @property double $duration
 * @property int $created_at
 * @property int $updated_at
 * @property int $clientid
 * @property string $hrftodcm
 * @property string $tag
 * @property int $soispolintel
 * @property int $postanovshik
 * @property string $description
 * @property string $donetime
 * @property string $type
 * @property boolean $new
 * @property int $deal_id
 */
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
     * Inversion relation Deal
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deal()
    {
        return $this->belongsTo(Deal::class, 'deal_id', 'id');
    }

    /**
     * Inversion relation Client
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clientsModel()
    {
        return $this->belongsTo(ClientsModel::class, 'clientid', 'id');
    }
}
