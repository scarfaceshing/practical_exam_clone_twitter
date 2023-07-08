<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;

class FollowerController extends Controller
{
    const IS_FOLLOW = true;
    const UN_FOLLOW = false;

    public function follow(Request $request, string $username) {
        $follower_id = $request->user()->id;
        $user_id = User::where('username', $username)->first()->id;

        $follower = Follower::updateOrCreate([
            'user_id' => $user_id,
            'follower_by_user' => $follower_id,
        ],[
            'is_follow' => self::IS_FOLLOW
        ]);
    }

    function un_follow(Request $request, string $username) {
        $follower_id = $request->user()->id;
        $user_id = User::where('username', $username)->first()->id;

        $follower = Follower::where('user_id', $user_id)->update([
            'is_follow' => self::UN_FOLLOW
        ]);
    }
}
