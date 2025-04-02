<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'sub_menu';

    protected $fillable = [
        'temple_id',
        'menu_id',
        'menu_type',
        'sub_menu_name',
        'url_type',
        'url',
        'icon_type',
        'icon',
        'icon_photo',
    ];

    public function mainMenu()
    {
        return $this->belongsTo(MainMenu::class, 'menu_id');
    }

}
