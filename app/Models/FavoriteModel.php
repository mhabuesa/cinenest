<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MovieModel;

class FavoriteModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function movie(){
        return $this->belongsTo(MovieModel::class, 'movie_id');
    }
}
