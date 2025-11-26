<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Notifications\Notifiable;

/**
 * @property int id
 * @property int loggable_id
 * @property string loggable_type
 * @property string description
 */
class Log extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'loggable_id',
        'loggable_type',
        'description',
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }
}
