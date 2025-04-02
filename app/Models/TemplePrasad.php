<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplePrasad extends Model
{
    use HasFactory;

    protected $table = 'temple__prasad_details';
    
    protected $fillable = [
        'temple_id',
        'prasad_name',
        'prasad_time',
        'prasad_price',
        'prasad_photo',
        'prasad_item',
        'description',
        'online_order',
        'pre_order',
        'offline_order'
    ];
    
}
