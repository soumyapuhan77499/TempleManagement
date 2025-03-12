<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearByTemple extends Model
{
    use HasFactory;
    
    protected $table = 'temple__near_by_temple';

    protected $fillable = [
      'temple_id',
      'temple_name',
      'photo', // Multiple photos stored as JSON
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
      'landmark',
      'pincode',
      'city_village',
      'district',
      'state',
      'country',
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
