<?php

namespace App\Models;

use App\Http\Requests\DealRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $description
 * @property boolean $status
 * @property string  $created_at
 * @property string  $updated_at
 * @property int $client_id // ID Клиента
 * @property int $user_id // ID Юриста
 */
class Deal extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    use HasFactory;

    protected $table = 'deals';

    protected $guarded = [];

    /**
     * @param DealRequest $request
     * @return $this
     */
    public static function new(DealRequest $request): self
    {
        $item = new self();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->status = $request->boolean('status');
        $item->client_id = $request->clientId;
        $item->user_id = $request->lawyerId;

        return $item;
    }

    /**
     * @param DealRequest $request
     * @return void
     */
    public function edit(DealRequest $request): void
    {
        $this->name = $request->name;
        $this->description = $request->description;
        $this->status = $request->boolean('status');
        $this->user_id = $request->lawyerId;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
