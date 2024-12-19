<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDressColor extends Model
{
    use HasFactory;
    protected $table = 'dress_color_deities_days';
    protected $fillable = [
        'day_name',
        'color',
        
    ];
}
