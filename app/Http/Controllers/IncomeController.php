<?php

namespace App\Http\Controllers;

use App\Repositories\incomeRepository;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    protected $income_r;

    function __construct()
    {
        $this->income_r = new incomeRepository;
    }

    function index()
    {
        return view('income.index');
    }

    function add()
    {
        return view('income.add');
    }

    function data(Request $request)
    {
        $data['data'] = $this->income_r->data($request);

        return view('income.data', $data);
    }

    function store(Request $request)
    {
        $data = $this->income_r->insert($request);

        return response()->json($data);
    }

    function edit($id)
    {
        $data['income'] = $this->income_r->getIncomeById($id);
        return view('income.edit', $data);
    }

    function update(Request $request)
    {
        $data = $this->income_r->update($request);

        return response()->json($data);
    }

    function delete($id)
    {
        $data = $this->income_r->delete($id);

        return response()->json($data);
    }
}
