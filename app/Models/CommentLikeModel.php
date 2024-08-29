<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLikeModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function rating(){
        return $this->belongsTo(CommentModel::class, 'comment_id');
    }
}
