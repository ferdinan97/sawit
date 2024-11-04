<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\staffRepository;

class StaffController extends Controller
{
    protected $staff_r;

    function __construct()
    {
        $this->staff_r  = new staffRepository;
    }

    function index(Request $request)
    {
        return view('staff.index');
    }

    function data(Request $request)
    {
        $data['staffs'] = $this->staff_r->getStaff($request);
        return view('staff.data', $data);
    }

    function add()
    {
        return view('staff.add');
    }

    function store(Request $request)
    {
        $response =  $this->staff_r->addStaff($request);
        return response()->json($response);
    }

    function edit($id)
    {
        $data['data'] = $this->staff_r->getStaffById($id);
        return view('staff.edit', $data);
    }

    function update(Request $request)
    {
        $response =  $this->staff_r->editStaff($request);
        return response()->json($response);
    }

    function delete($id)
    {
        $response =  $this->staff_r->deleteStaff($id);
        return response()->json($response);
    }
}
