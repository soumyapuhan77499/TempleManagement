<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleSocialMedia extends Model
{
    use HasFactory;

    // The table associated with the model.
    protected $table = 'temple__social_media';

    // The attributes that are mass assignable.
    protected $fillable = [
        'temple_id',
        'temple_images',
        'temple_videos',
        'temple_yt_url',
        'temple_ig_url',
        'temple_fb_url',
        'temple_x_url',
        'status',
    ];

    // Cast the temple_images and temple_videos attributes to arrays
    protected $casts = [
        'temple_images' => 'array',
        'temple_videos' => 'array',
    ];
    

    // Any other custom methods for the model can go here.
}

