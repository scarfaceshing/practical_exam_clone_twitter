<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
use App\Models\Twitter;

class FollowerController extends Controller
{
    const IS_FOLLOW = true;
    const UN_FOLLOW = false;

    public function follow(Request $request, string $username)
    {
        $follower_id = $request->user()->id;
        $user_id = User::where('username', $username)->first()->id;

        if ($follower_id !== $user_id) {
            $follower = Follower::updateOrCreate([
                'user_id' => $user_id,
                'follower_by_user' => $follower_id,
            ],[
                'is_follow' => self::IS_FOLLOW
            ]);
        } else {
            return response()->json([
                'message' => 'Can\'t follow same user'
            ]);
        }
    }

    public function un_follow(Request $request, string $username) {
        $follower_id = $request->user()->id;
        $user_id = User::where('username', $username)->first()->id;

        if ($follower_id !== $user_id) {
            $follower = Follower::where('user_id', $user_id)->update([
                'is_follow' => self::UN_FOLLOW
            ]);
        } else {
            return response()->json([
                'message' => 'Can\'t follow same user'
            ]);
        }
    }

    public function suggested_follow(User $user)
    {
        $follower = $user->suggestedToFollow($user->id)->get();

        return response()->json(['suggested_to_follow', $follower]);
    }

    public function list_followed_tweet(User $user)
    {
        $tweets_by_following = Follower::tweetByFollowing($user->id)->get();
        
        return response()->json(['following_tweets' => $tweets_by_following]);
    }
}
