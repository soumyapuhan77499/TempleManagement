<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeshaBooking extends Model
{
    use HasFactory;

    protected $table = 'temple__besha_booking';

    // Define the fillable attributes
    protected $fillable = [
        'booking_id',
        'besha_id',
        'name',
        'gotra',
        'phone_no',
        'date',
        'day_name',
    ];

    // Optionally, you can disable timestamps if your table does not have 'created_at' and 'updated_at'
    public $timestamps = true;

    
}
