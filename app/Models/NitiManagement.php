<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NitiManagement extends Model
{
    use HasFactory;

    protected $table = 'temple__niti_management';

    protected $fillable = [
        'niti_id',
        'day_id',
        'sebak_id',
        'date',
        'start_time',
        'pause_time',
        'running_time',
        'resume_time',
        'end_time',
        'duration',
        'start_user_id',
        'end_user_id',
        'start_time_edit_user_id',
        'end_time_edit_user_id',
        'niti_not_done_reason',
        'niti_status'
    ];
    public function master()
{
    return $this->belongsTo(NitiMaster::class, 'niti_id', 'niti_id');
}

}
