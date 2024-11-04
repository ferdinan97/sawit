<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Accurate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function viewLogin()
	{
		if (Auth::check()) {
			return redirect('dashboard');
		} else {
			return view('login');
		}
	}

	public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');

		if (Auth::guard('web')->attempt($credentials)) {
			return redirect()->route('dashboard.index');
		} else {
			return redirect()->route('login')->with('login_message', 'Login gagal. Periksa kembali email dan password anda');
		}
	}

	public function logout()
	{
		Auth::logout();
		return redirect('login');
	}

	public function getAccurateCode(Request $request)
	{
		$code = $request->code;
		Accurate::find(1)->update(['code' => $code]);
		return view('accurate');
	}
}
