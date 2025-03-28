<?php

// app/Models/TempleBanner.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleBanner extends Model
{
    use HasFactory;

    protected $table = 'temple__banner';

    protected $fillable = [
        'temple_id', 
        'banner_image',
        'banner_video', 
        'banner_type', 
        'banner_descp',
        'status'
    ];
}
