<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleTrustMemberDetail extends Model
{
    use HasFactory;

    protected $table = 'temple__trust_member_details'; // Specify the table name

   
    protected $fillable = [
        'temple_id',
        'trust_number',
        'member_name',
        'member_photo',
        'temple_designation',
        'member_designation',
        'dob',
        'member_contact_no',
        'whatsapp_number',
        'email',
        'about_member',
        'hierarchy_position',
        'trust_start_date',
        'trust_end_date',
        'status'
    ];
}

