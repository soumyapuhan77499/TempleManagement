<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DarshanDetails extends Model
{
    use HasFactory;

    protected $table = 'temple__darshan_details'; // Specify the table name
   
    protected $fillable = [
        'temple_id',
        'language',
        'day_id',
        'darshan_name',
        'darshan_type',
        'date',
        'start_time',
        'end_time',
        'duration',
        'description',
        'darshan_status',
        'status'
    ];
    
}
