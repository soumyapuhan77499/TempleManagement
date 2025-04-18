<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DarshanManagement extends Model
{
    use HasFactory;
    
    
    protected $table = 'temple__darshan_management';

    protected $fillable = [
        'temple_id',
        'darshan_id',
        'sebak_id',
        'date',
        'start_time',
        'end_time',
        'duration',
        'darshan_status'
    ];
}
