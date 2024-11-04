<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\reportRepository;

class ReportController extends Controller
{
    protected $report_r;

    function __construct()
    {
        $this->report_r  = new reportRepository;
    }

    function index()
    {
        return view('report.index');
    }

    function general_report()
    {
        $data['data'] = $this->report_r->getReport();

        return view('report.data', $data);
    }
}
