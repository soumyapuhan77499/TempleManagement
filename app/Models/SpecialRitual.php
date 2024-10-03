<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialRitual extends Model
{
    use HasFactory;
    protected $table = 'temple__yearly_ritual';

    protected $fillable = [
        'spcl_ritual_name',
        'spcl_ritual_date',
        'spcl_ritual_tithi',
        'spcl_ritual_time',
        'spcl_ritual_period',
        'description',
        'spcl_ritual_image',
        'spcl_ritual_video'
    ];
    

}
