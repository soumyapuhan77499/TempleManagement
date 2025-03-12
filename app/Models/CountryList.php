<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryList extends Model
{
    use HasFactory;

    protected $table = 'countries';
    
    protected $fillable = [
        'countryCode', 
        'name', 
        
    ];
    
 // Relationship with NearByTemple
 public function temples()
 {
     return $this->hasMany(NearByTemple::class, 'country');
 }

 // Relationship with States
 public function states()
 {
     return $this->hasMany(StateList::class, 'country_id');
 }
}
