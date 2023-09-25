<?php

namespace App\Http\Controllers\API;

use App\Helpers\JsonFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->input(), [
            "nis" => "required",
            "password" => "required" 
        ]);

        if ($validator->fails()) {
            return JsonFormatter::error("Data tidak lengkap.", data: $validator->errors()->all(),code:422);
        }
        $data = [
            'nis' => $request->nis,
            'password' => $request->password
        ];
        if (auth()->attempt($data)) {
            $user = auth()->user();
            
            if(!$user->period->status)
            {
                return JsonFormatter::error("Your Periode is not active.", code: 422);
            }

            $token = $user->createToken('user_token')->plainTextToken;;
            return JsonFormatter::success(
                [
                    'user' => $user,
                    'token' => $token
                ]
            );
        } else {
            return JsonFormatter::error("Unauthorised", code: 401);
        }
    }
}
