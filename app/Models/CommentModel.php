<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function visitor(){
        return $this->belongsTo(VisitorModel::class, 'visitor_id');
    }

    function movie(){
        return $this->belongsTo(MovieModel::class, 'movie_id');
    }

    public function replies()
    {
        return $this->hasMany(CommentReplyModel::class, 'comment_id');
    }
}
