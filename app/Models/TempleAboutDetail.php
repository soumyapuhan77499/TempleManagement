<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleAboutDetail extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'temple__about_details';

   // Disable timestamps
   public $timestamps = false;

   protected $fillable = [
       'temple_id',
       'temple_about',
       'temple_history',
       'endowment',
       'endowment_register_no',
       'endowment_document',
       'trust',
       'trust_register_no',
       'trust_document',
       'status',
   ];
}