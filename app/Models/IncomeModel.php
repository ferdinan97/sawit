<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeModel extends Model
{
    use HasFactory;

    protected $table = 'income';
    protected $fillable = [
        'total_weight',
        'price_per_kg',
    ];
}
