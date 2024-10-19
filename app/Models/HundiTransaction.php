<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HundiTransaction extends Model
{
    use HasFactory;

    protected $table = 'temple__hundi_transaction';

    // Add the columns to the fillable array
    protected $fillable = [
        'temple_id',
        'collection_id',
        'cash_type',
        'no_of_cash',
        'total_amount',
    ];
}
