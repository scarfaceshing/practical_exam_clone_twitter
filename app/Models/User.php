<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Follower;
use App\Models\Twitter;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function followers(): HasMany
    {
        return $this->hasMany(Follower::class, 'user_id');
    }

    public function following(): HasMany
    {
        return $this->hasMany(Follower::class, 'follower_by_user');
    }

    public function twitter(): HasMany
    {
        return $this->hasOne(Twitter::class, 'tweet_by_user');
    }

    public function scopeSuggestedToFollow(Builder $query, $user_id)
    {
        $query->whereNotIn('users.id', function ($query) use ($user_id) {
            $query->select('followers.user_id')
                ->from('followers')
                ->where('followers.follower_by_user', $user_id);
        });
    }
}
