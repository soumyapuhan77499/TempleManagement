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
        'member_name',
        'member_photo',
        'about_member',
        'member_designation',
        'member_contact_no',
        'status',
    ];
}

