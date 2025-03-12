<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    
    protected $table = 'temple__emergency_contact';
    
    protected $fillable = [
        'temple_id', 
        'type', 
        'contact_no', 
        'google_map_link', 
        'landmark',
        'pincode',
        'city_village',
        'district',
        'state',
        'country',
        'description',
    ];
}
