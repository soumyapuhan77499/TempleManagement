<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempleInventoryList extends Model
{
    use HasFactory;

    protected $table = 'temple__inventory_list';

    protected $fillable = [
        'temple_id',
        'item_name',
        'item_desc',
        'quantity',
        'photo',
        'inventory_category',
        'type',
        'status',
    ];
    public function inventorycategory()
    {
        return $this->belongsTo(TempleInventoryCategory::class, 'inventory_category',); // Change 'id' to the actual primary key if needed
    }
}
