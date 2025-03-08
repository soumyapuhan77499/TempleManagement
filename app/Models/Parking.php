<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;

    protected $table = 'temple__parking_details';

    protected $fillable = [
       'temple_id',
       'language',
       'vehicle_type',
       'pass_type',
       'parking_name',
       'parking_availability',
       'map_url',
       'parking_photo',
       'parking_address',
       'area_type',
       'parking_management',
       'status'
    ];

}