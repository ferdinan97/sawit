<?php

namespace App\Http\Controllers;

use App\Repositories\staffRepository;
use Illuminate\Http\Request;
use App\Repositories\workHistoryRepository;
use Carbon\Carbon;

class WorkHistoryController extends Controller
{
    protected $working_r, $staff_r;

    function __construct()
    {
        $this->working_r  = new workHistoryRepository();
        $this->staff_r  = new staffRepository();
    }

    function index(){
        return view('work_history.index');
    }

    function data(Request $request) {
        $date['date'] = $request['date'];
        if($date == null && $date = '') {
            $date = Carbon::now()->toDateString();
        }
        $datas['working_hour'] = $this->working_r->getWorkingHistory($date);
        return view('dashboard.data', $datas);
    }

    function history(Request $request) {
        $data['datas'] = $this->working_r->getWorkingHistoryList($request);
        return view('work_history.data', $data);
    }

    function add() {
        $data['staffs'] = $this->staff_r->getAllStaff();
        return view('work_history.add', $data);
    }

    function add_per_item() {
        $data['staffs'] = $this->staff_r->getAllStaff();
        return view('work_history.add_per_item', $data);
    }

    function store(Request $request){
        $data = $this->working_r->addWorkingHour($request);

        return response()->json($data);
    }

    function edit($id) {
        $data['history'] = $this->working_r->getWorkingHistoryById($id);
        $data['staffs'] = $this->staff_r->getAllStaff();
        return view('work_history.edit', $data);
    }

    function update(Request $request){
        $data = $this->working_r->updateWorkingHour($request);

        return response()->json($data);
    }

    function delete($id) {
        $data = $this->working_r->deleteWorkingHour($id);

        return response()->json($data);
    }
}
