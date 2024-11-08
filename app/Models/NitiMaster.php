<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NitiMaster extends Model
{
    use HasFactory;

    protected $table = 'temple__niti_master';

    protected $fillable = [

       'language',
       'niti_name',
       'description'
       
    ];

    public function steps()
    {
        return $this->hasMany(NitiStep::class, 'niti_id');
    }

    
}
