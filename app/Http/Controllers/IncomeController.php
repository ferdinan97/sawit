<?php

namespace App\Http\Controllers;

use App\Repositories\incomeRepository;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected $income_r;

    function construct()
    {
        $this->income_r = new incomeRepository;
    }

    function index()
    {
        return view('income.index');
    }
}
