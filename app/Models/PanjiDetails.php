<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanjiDetails extends Model
{
    use HasFactory;

    protected $table = 'temple__panji_details';

    protected $fillable = [
        'year',
        'date',
        'day',
        'language',
        'event_name',
        'tithi',
        'yoga',
        'nakshatra',
        'sun_set',
        'sun_rise',
        'good_time',
        'bad_time',
        'description',
        'status'
    ];

}
