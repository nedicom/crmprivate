<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property int $execution_time
 * @property string $description
 * @property string $url_disk
 */
class Services extends Model
{
    use HasFactory;

    protected  $fillable = ['name', 'price', 'execution_time', 'description', 'url_disk'];
}
