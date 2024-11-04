<?php

namespace App\Http\Controllers;

use App\Repositories\expenseRepository;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    //

    protected $expense_r;

    function __construct()
    {
        $this->expense_r  = new expenseRepository;
    }

    function index() {
        return view('expense.index');
    }

    function add() {
        return view('expense.add');
    }

    function data(Request $request){
        $data['data'] = $this->expense_r->data($request);

        return view('expense.data', $data);
    }

    function store(Request $request){        
        $data = $this->expense_r->insert($request);

        return response()->json($data);
    }

    function edit($id) {
        $data['expense'] = $this->expense_r->getExpenseById($id);
        return view('expense.edit', $data);
    }

    function update(Request $request) {        
        $data = $this->expense_r->update($request);

        return response()->json($data);
    }

    function delete($id) {
        $data = $this->expense_r->delete($id);

        return response()->json($data);
    }


}
