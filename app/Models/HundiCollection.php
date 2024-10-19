<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HundiCollection extends Model
{
    use HasFactory;

    protected $table = 'temple__hundi_collection';

    // Add your columns to the fillable array
    protected $fillable = [
        'temple_id',
        'transaction_id',
        'hundi_name',
        'hundi_open_date',
        'present_member',
        'opened_by',
        'collection_amount',
    ];
}
