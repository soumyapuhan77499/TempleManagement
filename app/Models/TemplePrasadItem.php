<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplePrasadItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'temple_id',
        'temple_prasad_id',
        'prasad_name',
        'prasad_price',
    ];

    // Define the relationship with TemplePrasad
    public function templePrasad()
    {
        return $this->belongsTo(TemplePrasad::class);
    }
}
