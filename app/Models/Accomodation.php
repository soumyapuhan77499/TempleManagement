<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    use HasFactory;

    protected $table = 'temple__accomodation_details';
   
    
    protected $fillable = [
       'temple_id',
       'name',
       'photo',
       'google_map_link',
       'accomodation_type',
       'contact_no',
       'whatsapp_no',
       'email',
       'check_in_time',
       'check_out_time',
       'address',
       'description',
       'food_type',
       'opening_time',
       'closing_time',
    ];
}
