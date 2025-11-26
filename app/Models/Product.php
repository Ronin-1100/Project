<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property int id
 * @property string name
 * @property int count
 * @property double price
 *
 * @property Trade trades
 */
class Product extends Model
{
    use HasFactory, Notifiable, Loggable, SoftDeletes;

    protected $fillable = [
        'name',
        'count',
        'price'
    ];

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }

    public function scopeUserId(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }
}
