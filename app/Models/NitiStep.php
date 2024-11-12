<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NitiStep extends Model
{
    use HasFactory;

    protected $table = 'temple__niti_step';

    protected $fillable = ['niti_id', 'step_name', 'seba_name']; // Ensure seba_name is in the fillable array
}
