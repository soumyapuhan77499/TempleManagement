<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDevotee extends Model
{
    use HasFactory;
    protected $table = 'temple__devotees';
    protected $fillable = [
        'name',
        'phone_number',
        'dob',
        'photo',
        'gotra',
        'rashi',
        'nakshatra',
        'anniversary_date',
        'address',
    ];
}
