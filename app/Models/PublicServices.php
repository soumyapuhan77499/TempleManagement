<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicServices extends Model
{
    use HasFactory;

    protected $table = 'temple__public_services';

    protected $fillable = [
       'temple_id',
       'service_type',
       'service_name',
       'photo',
       'google_map_link',
       'contact_no',
       'whatsapp_no',
       'opening_time',
       'closing_time',
       'landmark',
       'pincode',
       'city_village',
       'district',
       'state',
       'country',
       'description',
       'status'
    ];


}
