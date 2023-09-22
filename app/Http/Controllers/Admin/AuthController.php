<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $data = $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        $remember = false;
        if($request->remember)
        {
            $remember = true;
        }

        if(Auth::guard('admin')->attempt($data, $remember))
        {
            return redirect()->intended('/');
        }
        return redirect()->back()->with(AlertFormatter::danger('Username or Password invalid'));
    }
}
