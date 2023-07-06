<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    function login(Request $request) {

        $credentials = $request->only(['username', 'password']);

        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('API-TOKEN');
        
            return response()->json([
                'user_id' => $user->id,
                'token' => $token->plainTextToken
            ]);
        } else {
            return response()->json('Authentication Fail');
        }
        
        return response()->json($validator->errors());
    }

    function logout(Request $request) {
        try {
            $auth = $request->user()->currentAccessToken();

            $auth->delete();
            return response()->json('Logout success');
        } catch (Exception $e) {
            return response()->json('Login first');
        }
    }
}
