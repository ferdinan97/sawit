<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHourDetailModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'type',
        'total_item',
        'working_hour_id',
        'is_paid',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'working_hour_detail';

    function Staff()
    {
        return $this->belongsTo(StaffModel::class, 'staff_id', 'id');
    }

    function WorkHistory()
    {
        return $this->belongsTo(WorkHistoryModel::class, 'working_hour_id', 'id');
    }
}
