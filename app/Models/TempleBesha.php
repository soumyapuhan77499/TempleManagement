<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleBesha extends Model
{
    use HasFactory;
    protected $table = 'temple__beshas';

    protected $fillable = [
        'besha_name', 
        'items', 
        'description', 
        'estimated_time',
        'time_period',
        'total_time',
        'date',
        'weekly_day',
        'dress_color',
        'special_day',
        'photos',
    ];
}


