<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearByTemple extends Model
{
    use HasFactory;
    
    protected $table = 'temple__near_by_place';

    protected $fillable = [
      'temple_id',
      'name',
      'cover_photo',
      'place_type',
      'photo',
      'map_photo',
      'google_map_link',
      'type',
      'estd_date',
      'estd_by',
      'committee_name',
      'contact_no',
      'whatsapp_no',
      'email',
      'priest_name',
      'priest_contact_no',
      'distance_from_temple',
      'landmark',
      'pincode',
      'city_village',
      'district',
      'state',
      'country',
      'history',
      'description',
  ];

  public function countryData()
  {
      return $this->belongsTo(CountryList::class, 'country');
  }

  // Relationship with StateList
  public function stateData()
  {
      return $this->belongsTo(StateList::class, 'state');
  }

    
}
