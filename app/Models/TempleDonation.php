<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDonation extends Model
{
    use HasFactory;
    protected $table = 'temple__donations';

    protected $fillable = [
        'temple_id', 'donation_type', 'item_name', 'photo', 'item_desc', 'quantity', 'status',
    ];
}
