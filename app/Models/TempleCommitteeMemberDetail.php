<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleCommitteeMemberDetail extends Model
{
    use HasFactory;

    protected $table = 'temple__committee_member_details'; // Specify the table name


    protected $fillable = [
        'temple_id',
        'committee_id',
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
        'type',
        'committee_creation_date',
       'financial_period',
        'status',
        'reason'
    ];
}
