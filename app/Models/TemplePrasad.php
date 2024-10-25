<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplePrasad extends Model
{
    use HasFactory;
    protected $table = 'temple__prasads';
    
    protected $fillable = [
        'temple_id',
        'temple_prasad_id',
        'prasad_start_time',
       'prasad_start_period',
        'prasad_end_time',
        'prasad_end_period',
      'full_prasad_price',
        'online_order',
        'pre_order',
        'offline_order'
    ];
    public function prasadItems()
    {
        return $this->hasMany(TemplePrasadItem::class, 'temple_prasad_id', 'temple_prasad_id');
    }

}
