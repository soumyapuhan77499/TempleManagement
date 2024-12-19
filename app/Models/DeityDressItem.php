<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeityDressItem extends Model
{
    use HasFactory;
    protected $table = 'deity_dress_items';
    protected $fillable = ['item_name', 'description','status'];
}
