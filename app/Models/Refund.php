<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property int id
 * @property int trade_id
 * @property int count
 * @property int user_id
 * @property double price
 * @property string reason
 *
 * @property User user
 * @property Trade trade
 */
class Refund extends Model
{
    use HasFactory, Notifiable, Loggable, SoftDeletes;

    protected $fillable = [
        'trade_id',
        'count',
        'user_id',
        'price',
        'reason'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }

    public function scopeTradeId(Builder $query, int $tradeId): Builder
    {
        return $query->where('trade_id', $tradeId);
    }
}
