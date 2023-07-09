<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Twitter;
use Illuminate\Database\Eloquent\Builder;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_by_user',
        'is_follow'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follower(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_by_user');
    }

    public function twitter(): BelongsTo
    {
        return $this->belongsTo(Twitter::class, 'tweet_by_user', 'user_id');
    }

    public function scopeTweetByFollowing(Builder $query, $user_id)
    {
        $query
            ->leftJoin('twitters', 'followers.user_id', '=', 'twitters.tweet_by_user')
            ->leftJoin('users', 'users.id', '=', 'twitters.tweet_by_user')
            ->select('users.id', 'users.name', 'twitters.tweet')
            ->where('followers.is_follow', 1)
            ->where('followers.follower_by_user', $user_id)
            ->get();
    }
}
