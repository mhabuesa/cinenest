<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessageModel;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    function message(){


        if(Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator'){
            $messages = ContactMessageModel::latest()->get();
            return view('backend.message.message', [
                'messages'=>$messages,
            ]);
           }
           else{
            return redirect()->route('dashboard');
           }
    }


    function message_read($id){
        if(Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator'){
            $message = ContactMessageModel::find($id);
            if($message->status == 0){
                $message->update([
                    'status'=>1
                ]);
            }
            return view('backend.message.message_read',[
                'message'=>$message,
            ]);
           }
           else{
            return redirect()->route('dashboard');
           }
    }



}
