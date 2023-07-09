<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Twitter;
use App\Models\Follower;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Twitter extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:m:s',
    ];

    protected $fillable = [
        'tweet',
        'file_name',
        'file_path',
        'tweet_by_user',
    ];

    public function users(): BelongsTo {
        return $this->belongsTo(User::class, 'tweet_by_user');
    }

    public function follower(): BelongsTo
    {
        return $this->belongsTo(Twitter::class, 'user_id', 'tweet_by_user');
    }
}
