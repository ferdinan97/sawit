<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'staffs';
    protected $fillable = [
        'name', 'created_at', 'updated_at', 'deleted_at'
    ];

}
