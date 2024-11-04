<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseDetailModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'expense_detail';
    protected $fillable = [
        'name',
        'total',
        'expense_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    function Expense(){
        return $this->belongsTo(ExpenseModel::class, 'expense_id', 'id');
    }
}