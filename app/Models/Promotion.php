<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * @property int id
 * @property int product_id
 * @property int count
 * @property double price
 * @property int user_id
 * @property double discount_sum
 * @property int discount_percent
 *
 * @property Product product
 * @property User user
 */
class Promotion extends Model
{
    use HasFactory, Notifiable, Loggable, SoftDeletes;

    protected $fillable = [
        'product_id',
        'count',
        'price',
        'user_id',
        'discount_sum',
        'discount_percent',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeProductId(Builder $query, int $productId): Builder
    {
        return $query->where('product_id', $productId);
    }
}
