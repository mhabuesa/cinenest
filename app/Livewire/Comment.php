<?php

namespace App\Livewire;

use App\Models\CommentLikeModel;
use App\Models\CommentModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Comment extends Component
{
    public $movie;
    public $comment = '';
    public $likesCount;
    public $dislikesCount;
    public $id;



    public function comments(){
        $this->validate([
            'comment'=>'required',
        ]);

        CommentModel::create([
            "visitor_id"=>Auth::guard('visitor')->user()->id,
            "movie_id"=>$this->movie->id,
            "comment"=> $this->comment,
        ]);


        $this->reset(['comment']);
        request()->session()->flash('commented', 'Commented Successfully');


    }

    public function render()
    {

        $comments = CommentModel::with('replies')->where('movie_id', $this->movie->id)->latest()->get();
        return view('livewire.comment',[
            'movie'=> $this->movie,
            'comments'=> $comments,
        ]);
    }


    public function like($id){

        $visitor = Auth::guard('visitor')->user();
         // Check if the user has already liked or disliked this comment
         $likeRecord = CommentLikeModel::where('comment_id', $id)
         ->where('visitor_id', $visitor->id)
         ->first();

        if ($likeRecord) {
        // If the record exists, check its current state
        if ($likeRecord->like == 0) {
        // Update the like status
        $likeRecord->update([
            'like' => 1,
            'dislike' => 0 // Assuming dislike should be reset
        ]);
        }
        } else {
        // Create a new like record if it doesn't exist
        CommentLikeModel::create([
        'visitor_id' => $visitor->id,
        'comment_id' => $id,
        'like' => 1,
        'dislike' => 0
        ]);
        }

        $this->likesCount = CommentLikeModel::where('comment_id', $id)->where('like', 1)->count();

    }


    public function dislike($id){

        $visitor = Auth::guard('visitor')->user();
         // Check if the user has already liked or disliked this comment
         $dislikeRecord = CommentLikeModel::where('comment_id', $id)
         ->where('visitor_id', $visitor->id)
         ->first();

        if ($dislikeRecord) {
        // If the record exists, check its current state
        if ($dislikeRecord->dislike == 0) {
        // Update the like status
        $dislikeRecord->update([
            'like' => 0,
            'dislike' => 1 // Assuming dislike should be reset
        ]);
        }
        } else {
        // Create a new like record if it doesn't exist
        CommentLikeModel::create([
        'visitor_id' => $visitor->id,
        'comment_id' => $id,
        'like' => 0,
        'dislike' => 1
        ]);
        }

    }




}
