<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NijogaMaster extends Model
{
    use HasFactory;

    protected $table = 'temple__master_nijoga';

    protected $fillable = [
       'temple_id',
       'nijoga_name',
       'nijoga_photo',
       'description',
    ];

}
