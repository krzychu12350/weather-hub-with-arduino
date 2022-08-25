<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherDataLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'temperature',
        'humidity',
        'favourite_place_id',
    ];

    /**
     * Get the favourite place that owns the weather data log.
     */
    public function favouritePlace(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(FavouritePlace::class);
    }
}
