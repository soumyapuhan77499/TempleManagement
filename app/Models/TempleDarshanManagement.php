<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDarshanManagement extends Model
{
    use HasFactory;

    protected $table = 'temple__darshan_management'; // Specify the table name
   
    protected $fillable = [
        'temple_id',
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
