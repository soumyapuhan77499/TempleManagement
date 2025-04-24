<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NitiManagement;

class NitiMaster extends Model
{
    use HasFactory;

    protected $table = 'temple__niti_details';

    protected $fillable = [
        'temple_id',
        'niti_id',
        'day_id',
        'language',
        'niti_name',
        'date_time',
        'after_special_niti',
        'niti_type',
        'niti_privacy',
        'niti_about',
        'niti_sebayat',
        'description',
        'connected_mahaprasad_id',
        'connected_darshan_id',
        'niti_status'
    ];

    public function steps()
    {
        // Ensuring the correct foreign key is used for `steps`
        return $this->hasMany(NitiStep::class, 'niti_id', 'niti_id');
    }

    public function niti_items()
    {
        // Ensuring the correct foreign key is used for `niti_items`
        return $this->hasMany(NitiItems::class, 'niti_id', 'niti_id');
    }

public function todayStartTime()
{
    return $this->hasOne(NitiManagement::class, 'niti_id', 'niti_id')
        ->where('niti_status', 'Started')
        ->whereDate('date', now()->toDateString());
}


public function todayStartCompleteTime()
{
    return $this->hasOne(NitiManagement::class, 'niti_id', 'niti_id')
        ->where('niti_status', ['Started', 'Completed'])
        ->whereDate('date', now()->toDateString());
}

public function subNitis()
{
    return $this->hasMany(TempleSubNiti::class, 'niti_id', 'niti_id');
}

public function afterSpecial()
{
    return $this->belongsTo(NitiMaster::class, 'after_special_niti', 'niti_id');
}


public function linkedDarshan()
{
    return $this->belongsTo(DarshanDetails::class, 'connected_darshan_id');
}

public function linkedMahaprasad()
{
    return $this->belongsTo(TemplePrasad::class, 'connected_mahaprasad_id');
}



}
