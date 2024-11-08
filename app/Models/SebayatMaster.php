<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SebayatMaster extends Model
{
    use HasFactory;
    protected $table = 'temple__sebayat_master';

    protected $fillable = [
        'language',
       'sebayat_name',
       'description'
    ];
}
