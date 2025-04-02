<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainMenu extends Model
{
    use HasFactory;

    protected $table = 'main_menu';

    protected $fillable = [
        'temple_id',
        'menu_name',
        'url_type',
        'url',
        'icon',
    ];
}
