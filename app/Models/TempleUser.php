<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class TempleUser extends Authenticatable
{
    use HasFactory;
    protected $table = 'temple__user_login';

    protected $fillable = [
        'temple_id',
        'temple_name',
        'user_name',
        'mobile_no',
        'temple_trust_name',
        'trust_contact_no',
        'temple_address',
    ];

}
