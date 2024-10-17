<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsideTemple extends Model
{
    use HasFactory;
    
    protected $table = 'temple__inside_temple';

    protected $fillable = [
        'temple_id', 
        'inside_temple_name', 
        'inside_temple_image', 
        'description',
        'status',
    ];

}
