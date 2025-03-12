<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommuteMode extends Model
{
    use HasFactory;

    protected $table = 'temple__commute_mode';
    
    protected $fillable = [
        'temple_id', 
        'commute_type', 
        'name',
        'photo',
        'google_map_link',
        'distance_from_temple',
        'landmark',
        'pincode',
        'city_village',
        'district',
        'state',
        'country',
        'description'
    ];
    
}
