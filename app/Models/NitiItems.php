<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NitiItems extends Model
{
    use HasFactory;

    protected $table = 'temple__niti_items';

    protected $fillable = [
       'niti_id',
       'item_name',
       'quantity',
       'unit',
    ];

    // Define a relationship back to NitiMaster if needed
    public function niti()
    {
        return $this->belongsTo(NitiMaster::class, 'niti_id');
    }
}
