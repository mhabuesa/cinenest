<?php

namespace App\Http\Controllers;

use App\Models\CommentModel;
use App\Models\CommentReplyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    function comment_store(Request $request){
        $request->validate([
            "comment"=> "",
        ]);

        CommentModel::create([
            "visitor_id"=>Auth::guard('visitor')->user('id'),
            "movie_id"=> $request->movie_id,
            "comment"=> $request->comment,
        ]);
        return back()->with("success","");
    }

    function comments(){
        $comments = CommentModel::with('replies')->latest()->get();
        return view("backend.comments.comments", compact("comments"));
    }

    function reply_store(Request $request, $id){

        CommentReplyModel::create([
            'comment_id'=>$id,
            'reply'=>$request->reply,
        ]);
        return back()->with('success','Comment Stored Successfully');
    }
}
