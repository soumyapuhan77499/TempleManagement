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
        'temple_id',
       'sebayat_name',
       'description'
    ];
}
