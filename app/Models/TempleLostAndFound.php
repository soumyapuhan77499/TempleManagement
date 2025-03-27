<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleLostAndFound extends Model
{
    use HasFactory;

    protected $table = 'temple__lost_and_found';

    protected $fillable = [
        'temple_id',
        'name',
        'phone_no',
        'address',
        'type',
        'item_name',
        'item_photo',
        'item_location',
        'description',
        'status'
    ];
}
