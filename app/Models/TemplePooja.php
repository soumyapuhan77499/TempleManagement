<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplePooja extends Model
{
    protected $table = 'temple__pooja_booking_details';

    protected $fillable = [
        'temple_id', 'pooja_image', 'pooja_name', 'pooja_price', 'pooja_descp', 'status'
    ];
}
