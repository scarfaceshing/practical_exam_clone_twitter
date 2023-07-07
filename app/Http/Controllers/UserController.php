<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    function user(Request $request) {
        return $request->user();
    }

    function profile($username) {
        $user = User::where(['username' => $username])->firstOrFail();
        return $user;
    }
}
