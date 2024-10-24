<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplePrasad extends Model
{
    use HasFactory;
    protected $table = 'temple__prasads';
    protected $fillable = [
        'temple_id',
        'prasad_name',
        'prasad_price',
        'darshan_start_time',
        'darshan_start_period',
        'darshan_end_time',
        'darshan_end_period',
        'online_order',
        'pre_order',
        'offline_order'
    ];
}
