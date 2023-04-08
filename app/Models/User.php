<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use App\Models\ClientsModel;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    public function clients(): HasMany
    {
          return $this->hasMany(ClientsModel::class);
      }

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'tg_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAvatar(): ?string
    {
        return $this->avatar
            ? Str::replaceFirst('/public/', '/', $this->avatar)
            : $this->avatar;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
