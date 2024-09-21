<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleNews extends Model
{
    protected $table = 'temple__news';

    protected $fillable = [
        'temple_id', 'notice_name', 'notice_date', 'notice_descp', 'status'
    ];
}
