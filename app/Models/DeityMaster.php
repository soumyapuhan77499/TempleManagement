<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeityMaster extends Model
{
    use HasFactory;

    protected $table = 'temple__deity_master';

    protected $fillable = [
        'language',
       'deity_name',
       'description'
    ];
}
