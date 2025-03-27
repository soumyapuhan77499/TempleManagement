<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleDonation extends Model
{
    use HasFactory;
    protected $table = 'temple__donations';

    protected $fillable = [
        'temple_id', 'donation_id', 'donated_by', 'donation_amount', 'donation_date_time',
        'phone_number', 'address', 'pan_card', 'type', 'status', 'payment_mode', 
        'payment_number', 'item_name', 'quantity', 'item_image','description'
    ];
}
