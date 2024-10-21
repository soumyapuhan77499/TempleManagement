<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleCommittee extends Model
{
    use HasFactory;
    protected $table = 'temple__committee_details';
    protected $fillable = [
        'temple_id',
        'committee_id',
        'committee_creation_date',
        'financial_period',
        'committee_end_date',
        'status',
    ];
}
