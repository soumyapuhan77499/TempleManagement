<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubFestival extends Model
{
    use HasFactory;

    protected $table = 'temple__sub_festival';

    protected $fillable = [
        'temple_id',
        'festival_id',
        'sub_festival_name',
        'sub_festival_date',
        'sub_festival_photo',
        'sub_festival_time',
        'status'
        ];

}
