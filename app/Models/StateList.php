<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateList extends Model
{
    use HasFactory;

    protected $table = 'states';
    
    protected $fillable = [
        'country_id', 
        'name', 
    ];

    public function temples()
    {
        return $this->hasMany(NearByTemple::class, 'state');
    }

    // Relationship with CountryList
    public function country()
    {
        return $this->belongsTo(CountryList::class, 'country_id');
    }
}
