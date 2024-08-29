<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function movie(){
        return $this->belongsTo(MovieModel::class, 'movie_id');
    }
    function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
