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
        'darshan_start_time',
       
        'darshan_end_time',
      
        'online_order',
        'pre_order',
        'offline_order'
    ];
    public function prasadDetails()
{
    return $this->hasMany(TemplePrasadItem::class, 'temple_prasad_id');
}

}
