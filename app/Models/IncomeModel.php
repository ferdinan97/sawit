<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeModel extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'income';
    protected $fillable = [
        'date',
        'description',
        'total_weight',
        'price_per_kg',
        'total',
        'created_at',
        'updated_at',
    ];
}
