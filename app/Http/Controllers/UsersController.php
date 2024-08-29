<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Payment;
use App\Models\PaymentInfoModel;
use App\Models\PayoutRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    function users(){
        if(Auth::user()->roll == 'admin'){
            $users = User::where('id', '!=', Auth::user()->id)->get();
            return view('backend.users.users',[
                'users'=>$users,
            ]);
        }
        else{
            return redirect()->route('unauthorized');
        }
    }

    function users_store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'roll'=>'required',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'roll'=>$request->roll,
            'created_at'=>Carbon::now(),
        ]);

        if($request->rate == null){
            PaymentInfoModel::create([
                'user_id'=>$user->id,
                'rate'=>'5',
                'point'=>'0',
            ]);
        }
        else{
            PaymentInfoModel::create([
                'user_id'=>$user->id,
                'rate'=>$request->rate,
                'point'=>'0',
            ]);
        }


        return back()->with('created', 'User Created Successfully');
    }

    function users_edit($id){
       if(Auth::user()->roll == 'admin'){
        $user = User::find($id);
        return view('backend.users.users_edit',[
            'user'=>$user,
        ]);
       }
       else{
        return redirect()->route('unauthorized');
       }
    }

    function users_update(Request $request, $id){
        $user = User::find($id);
        if($request->email == $user->email){

            if($request->password == ''){
                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'roll'=>$request->roll,
                ]);

            }

            else{
                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'roll'=>$request->roll,
                ]);

            }
            return back()->with('update', 'User Updated Successfully');

        }
        else{
            $request->validate([
                'email'=>'unique:users'
            ]);
            if($request->password == ''){
                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'roll'=>$request->roll,
                ]);

            }

            else{
                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>bcrypt($request->password),
                    'roll'=>$request->roll,
                ]);
            }
            return back()->with('update', 'User Updated Successfully');
        }
    }

    function users_delete($id){
        ActivityLog::find($id)->delete();
        Payment::where('user_id', $id)->delete();
        PaymentInfoModel::where('user_id', $id)->delete();
        PayoutRequest::where('user_id', $id)->delete();
        User::find($id)->delete();
        return back()->with('delete', 'User Deleted Successfully');
    }


}
