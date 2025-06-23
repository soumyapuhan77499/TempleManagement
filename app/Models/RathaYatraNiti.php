<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RathaYatraNiti extends Model
{
    use HasFactory;

    protected $table = 'ratha__yatra_niti_details';

    protected $fillable = [
        'niti_id',
        'day_id',
        'odia_niti_name',
        'english_niti_name',
        'date',
        'niti_type',
        'start_time',
        'end_time',
        'start_user_id',           
        'end_user_id',           
        'start_time_edit_user_id',           
        'end_time_edit_user_id',           
        'niti_not_done_reason',
        'not_done_user_id',           
        'niti_status',           
    ];
}
