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
 * @property int product_id
 * @property int count
 * @property int user_id
 * @property double price
 * @property int promotion_id
 *
 * @property Product product
 * @property User user
 * @property Promotion promotion
 * @property Refund refund
 */
class Trade extends Model
{
    use HasFactory, Notifiable, Loggable, SoftDeletes;

    protected $fillable = [
        'product_id',
        'count',
        'user_id',
        'price',
        'promotion_id'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }

    public function scopeProductId(Builder $query, int $productId): Builder
    {
        return $query->where('product_id', $productId);
    }
}
