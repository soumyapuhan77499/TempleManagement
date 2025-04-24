<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDarshan extends Model
{
    use HasFactory;
    protected $table = 'temple__darshan_time';

    protected $fillable = [
        'language',
        'temple_id',
        'darshan_day',
        'darshan_name',
        'darshan_start_time',
        'darshan_end_time',
        'darshan_duration',
        'darshan_image',
        'description',
        'created_at',
        'updated_at',
        'status'
    ];
}
