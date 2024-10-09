<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleTitle extends Model
{
    use HasFactory;
    protected $table = 'temple__title';

    protected $fillable = ['title', 'status'];
}
