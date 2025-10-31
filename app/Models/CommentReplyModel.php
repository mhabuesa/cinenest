<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReplyModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function reply(){
        return $this->belongsTo(CommentModel::class, 'comment_id');
    }

}
