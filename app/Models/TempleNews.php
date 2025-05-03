<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleNews extends Model
{
    protected $table = 'temple__news';

    protected $fillable = [
        'type','temple_id', 'notice_name','niti_notice', 'start_date', 'end_date', 'notice_descp', 'status'
    ];
    
}
