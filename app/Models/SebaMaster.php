<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SebaMaster extends Model
{
    use HasFactory;

    protected $table = 'temple__seba_master';

    protected $fillable = [
       'language',
       'seba_name',
       'description'
    ];
    
    public function steps()
    {
        return $this->hasMany(SebaStep::class, 'seba_id');
    }
    

}
