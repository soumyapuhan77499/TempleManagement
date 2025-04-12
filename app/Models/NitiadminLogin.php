<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class NitiadminLogin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'temple__niti_admin_login';

    protected $fillable = [
        'sebak_id',
        'name',
        'mobile_no',
        'otp',
        'email',
        'profile_photo',
        'order_id',
        'expires_at',
        'hash',
        'client_id',
        'client_secret',
        'otp_length',
        'channel',
    ];
}
