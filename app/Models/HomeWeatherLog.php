<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeWeatherLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'temperature_at_home',
        'humidity_at_home',
        'pressure_at_home',
        'light_intensity_at_home',
    ];
}
