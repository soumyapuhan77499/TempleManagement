<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearByTemple extends Model
{
    use HasFactory;
    
    protected $table = 'temple__near_by_temple';

    protected $fillable = [
       'temple_id',
       'temple_name',
       'photo',
       'google_map_link',
       'area_type',
       'estd_date',
       'estd_by',
       'committee_name',
       'contact_no',
       'whatsapp_no',
       'email',
       'priest_name',
       'priest_contact_no',
      'description',
      'landmark',
      'pincode',
      'city_village',
      'district',
      'state',
      'country',
    ];
}
