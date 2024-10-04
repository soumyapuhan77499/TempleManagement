<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleInventoryCategory extends Model
{
    protected $table = 'temple__inventory_category';

    protected $fillable = ['temple_id', 'inventory_categoy', 'status'];
}

