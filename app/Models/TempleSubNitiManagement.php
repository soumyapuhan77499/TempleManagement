<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleSubNitiManagement extends Model
{
    
    use HasFactory;

    protected $table = 'temple__sub_niti_management';

    protected $fillable = [
        'temple_id',
        'sebak_id',
        'day_id',
        'niti_id',
        'sub_niti_id',
        'sub_niti_name',
        'date',
        'start_time',
        'status',
        'created_at',
        'updated_at'
    ];
}
