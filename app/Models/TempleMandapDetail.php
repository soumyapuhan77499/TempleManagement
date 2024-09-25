<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleMandapDetail extends Model
{
    use HasFactory;

    protected $table = 'temple__mandap_details';

    protected $fillable = [
        'temple_id',
        'mandap_name',
        'mandap_description',
        'booking_type',
        'event_name',
        'price_per_day',
        'status'
    ];
}

