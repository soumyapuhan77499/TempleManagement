<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorBank extends Model
{
    use HasFactory;
    protected $table = 'temple__vendor_bank';
    protected $fillable = [
        'temple_id', 
        'vendor_id', 
        'bank_name', 
        'account_no', 
        'ifsc_code', 
        'upi_id', 
       
    ];
    public function vendor()
    {
        return $this->belongsTo(VendorDetails::class, 'vendor_id', 'vendor_id');
    }

}
