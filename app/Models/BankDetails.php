<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetails extends Model
{
    use HasFactory;
    protected $table = 'temple__bank_details';
    protected $fillable = ['temple_id','bank_name','account_no','ifsc_code','acc_holder_name','upi_id']; 
}
