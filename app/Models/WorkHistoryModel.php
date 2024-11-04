<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkHistoryModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'date',
        'price_per_item',
        'type',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $table = 'working_hours';

    function Detail()
    {
        return $this->hasMany(WorkingHourDetailModel::class, 'working_hour_id', 'id');
    }
}
