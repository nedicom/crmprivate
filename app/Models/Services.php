<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property double $execution_time
 * @property string $type_execution_time
 * @property string $description
 * @property string $url_disk
 */
class Services extends Model
{
    use HasFactory;

    const TYPE_DURATION_OLD = 'old';
    const TYPE_DURATION_NEW = 'new';

    protected  $fillable = ['name', 'price', 'execution_time', 'type_execution_time', 'description', 'url_disk'];

    /** Устанавливаем значение продоолжительности
     * @param array $duration
     * @return void
     */
    public function setDuration(array $duration): void
    {
        $this->execution_time = (int) ($duration['hours'] * 60) + $duration['minutes'];
        $this->type_execution_time = static::TYPE_DURATION_NEW;
    }
}
