<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleFestival extends Model
{
    use HasFactory;

    protected $table = 'temple__festival';

    protected $fillable = [
        'temple_id',
        'festival_id',
        'festival_name',
        'start_date',
        'end_date',
        'photo',
        'live_url',
        'description',
        'status'
        ];

        public function subFestivals()
{
    return $this->hasMany(SubFestival::class, 'festival_id', 'festival_id');
}


}
