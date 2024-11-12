<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NitiMaster extends Model
{
    use HasFactory;

    protected $table = 'temple__niti_details';

    protected $fillable = [
        'niti_id',
        'language',
        'niti_name',
        'date_time',
        'niti_type',
        'niti_about',
        'niti_sebayat',
        'description'
    ];

    public function steps()
    {
        // Ensuring the correct foreign key is used for `steps`
        return $this->hasMany(NitiStep::class, 'niti_id', 'niti_id');
    }

    public function niti_items()
    {
        // Ensuring the correct foreign key is used for `niti_items`
        return $this->hasMany(NitiItems::class, 'niti_id', 'niti_id');
    }
}
