<?php

namespace App\Http\Controllers;

use function Ramsey\Uuid\v1;

class DashboardController extends Controller
{
    function index() {
        return view('dashboard.index');
    }
}
