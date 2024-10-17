<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleExpenditure extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'temple__expenditure_details';

    // Add the fillable fields
    protected $fillable = [
        'temple_id',
        'voucher_number',
        'payment_date',
        'amount',
        'person_name',
        'category',
        'category_type',
        'payment_mode',
        'payment_number',
        'payment_done_by',
        'payment_description',
        'status'
    ];

    public function vendor()
    {
        return $this->belongsTo(VendorDetails::class, 'vendor_id');
    }
}
