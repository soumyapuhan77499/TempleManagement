<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SebaStep extends Model
{
    use HasFactory;

    protected $table = 'temple__seba_step';

    protected $fillable = ['seba_id', 'step_name', 'status'];

}
