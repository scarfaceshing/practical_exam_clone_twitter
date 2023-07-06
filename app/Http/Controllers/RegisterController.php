<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    const UNPROCESSABLE_CONTENT = 422;

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'regex:/^[a-zA-Z]+$/u'],
            'username' => ['required', 'max:20', 'min:5', 'regex:/^[a-z0-9]+$/u'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), self::UNPROCESSABLE_CONTENT);
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        return response()->json('Register Successfully');
    }
}
