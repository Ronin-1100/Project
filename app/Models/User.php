<?php

namespace App\Models;

use App\Enums\UserType;
use App\Traits\Loggable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 * @property UserType type
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection trades
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, Loggable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'type' => UserType::class,
        ];
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
