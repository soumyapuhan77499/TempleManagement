<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleRitual extends Model
{
    use HasFactory;
    protected $table = 'temple__daily_ritual';

    protected $fillable = [
        'temple_id',
        'ritual_name',
        'ritual_day_name',
        'ritual_date',
        'ritual_start_time',
        'ritual_end_time',
        'ritual_duration',
        'ritual_image',
        'ritual_video',
        'description',
        'status',
    ];
}
