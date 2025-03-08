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
       'address',
       'description',
       'status'
    ];

}
