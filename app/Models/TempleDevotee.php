<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDevotee extends Model
{
    use HasFactory;
    protected $table = 'temple__devotees';
    protected $fillable = [
        'temple_id',
        'name',
        'phone_number',
        'dob',
        'photo',
        'gotra',
        'rashi',
       
        'anniversary_date',
        'address',
    ];
}
