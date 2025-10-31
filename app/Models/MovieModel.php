<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MovieModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
