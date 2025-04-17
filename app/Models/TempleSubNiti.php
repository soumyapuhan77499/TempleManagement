<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleSubNiti extends Model
{
    use HasFactory;

    protected $table = 'temple__sub_niti';

    protected $fillable = [
        'temple_id',
        'niti_id',
        'sub_niti_name',
        'created_at',
        'updated_at'
    ];

}
