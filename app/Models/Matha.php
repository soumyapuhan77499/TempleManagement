<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matha extends Model
{
    use HasFactory;

    protected $table = 'temple__matha_details';

    protected $fillable = [
       'temple_id',
       'matha_name',
       'mahanta_name',
       'photo',
       'established_date',
       'established_by',
       'relation_with_temple',
       'endowment',
       'availability',
       'google_map_link',
       'whatsapp_no',
       'contact_no',
       'email_id',
       'description',
       'landmark',
       'pincode',
       'city_village',
       'district',
       'state',
       'country',
       'status'
    ];

}
