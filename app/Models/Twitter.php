<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twitter extends Model
{
    use HasFactory;

    protected $fillable = [
        'tweet',
        'file_name',
        'file_path',
        'uploaded_by_user',
    ];
}
