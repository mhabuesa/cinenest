<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryModel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function rel_to_color(){
        return $this->belongsTo(MovieModel::class, 'movie_id');
    }
}
