<?php

namespace App\Http\Controllers;

use App\Models\TodoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    function todo_list(){

        $todos = TodoModel::latest()->get();
        return view('backend.todo.todo', [
            'todos'=>$todos,
        ]);
    }

    function todo_store(Request $request){
        $request->validate([
            'title' => 'required',
            'release_year' => 'required',
        ]);

         if(TodoModel::where('status', 0)->count() >= 40){
            return back()->with('error', 'You can not add more than 40 movies');
        }
        TodoModel::create([
            'title' => $request->title,
            'release_year' => $request->release_year,
        ]);

        return redirect()->route('todo.list')->with('success', 'Movie Title Added Successfully');
    }

    function todo_assign($id){
        TodoModel::find($id)->update([
            'status' => 1,
            'user_id' => Auth::user()->id,
        ]);
        return back()->with('success', 'Assigned Successfully');
    }

    function todo_complete($id){
        TodoModel::find($id)->update([
            'status' => 2,
        ]);
        return back()->with('success', 'Completed Successfully');
    }
    
    function todo_delete($id){
        TodoModel::find($id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }

}
