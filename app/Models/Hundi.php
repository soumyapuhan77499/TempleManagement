<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hundi extends Model
{
    use HasFactory;
    protected $table = 'temple__hundi';

    // Add the columns to the fillable array
    protected $fillable = [
        'temple_id',
        'hundi_name',
        'description',
    ];
}
