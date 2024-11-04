<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'expense';
    protected $fillable = [
        'name',
        'total',
        'date',
        'description',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    function Detail() {
        return $this->hasMany(ExpenseDetailModel::class, 'expense_id', 'id');
    }
}
