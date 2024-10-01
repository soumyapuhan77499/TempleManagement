<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleFestival extends Model
{
    use HasFactory;

    protected $table = 'temple__festival';

    protected $fillable = ['festival_name', 'festival_date', 'festival_descp', 'temple_id', 'status'];

}
