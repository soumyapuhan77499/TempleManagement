<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleTrustDetail extends Model
{
    use HasFactory;
    protected $table = 'temple__trust_details';

    protected $fillable = [
        'temple_id', 
        'trust_name', 
        'trust_number', 
        'trust_contact_no', 
        'trust_start_date', 
        'trust_end_date', 
        'total_day'
    ];
}
