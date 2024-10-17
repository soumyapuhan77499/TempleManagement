<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplePhotosVideos extends Model
{
    use HasFactory;
    protected $table = 'temple__photos_videos';

    // The attributes that are mass assignable.
    protected $fillable = [
        'temple_id',
       'temple_images',
       'temple_videos',
       
    ];

    // Cast the temple_images and temple_videos attributes to arrays
    protected $casts = [
        'temple_images' => 'array',
        'temple_videos' => 'array',
    ];
    

}
