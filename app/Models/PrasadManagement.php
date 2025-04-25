<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrasadManagement extends Model
{
    use HasFactory;

    protected $table = 'temple__prasad_management';

    protected $fillable = [
        'day_id',
        'temple_id',
        'prasad_id',
        'sebak_id',
        'date',
        'start_time',
        'prasad_status'
    ];
    

}
