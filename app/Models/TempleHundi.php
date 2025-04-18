<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleHundi extends Model
{
    use HasFactory;

    protected $table = 'temple__hundi_notice';

    protected $fillable = [
        'temple_id', 'date', 'rupees', 'gold', 'silver'
    ];
}
