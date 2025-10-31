<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPassMail;
use App\Mail\PassResetMail;
use App\Mail\VerificationMail;
use App\Models\VisitorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class VisitorAuthController extends Controller
{
    function visitor_store(Request $request){
        $request->validate([
            "name"=> "required",
            "email"=> "required|email|unique:visitor_models",
            "password"=> "required",
            'password_confirmation'=>['required', 'same:password'],
        ]);

        $code = random_int(00000,999999);

        $visitor = VisitorModel::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'code'=> $code,
            'unique_id'=>uniqid(),
            'verified'=>'verify',
        ]);

        // Mail::to($request->email)->send(new VerificationMail($code));
        // $uniqueId = $visitor->unique_id;
        // return redirect()->route('verification',$uniqueId)->with('success','Verification code Sent to your email');
        Auth::guard('visitor')->login($visitor);
        return redirect()->route('index');
    }

    function verify(Request $request, $uniqueId){
        $request->validate([
            'code'=>'required'
        ]);

        $unique_id = VisitorModel::where("unique_id",$uniqueId)->first();
        if($unique_id->code == $request->code){
            $unique_id->update([
                'verified'=>'verify',
                'code'=>null,
                'unique_id'=>null,

            ]);
            return redirect()->route('signin')->with('success','Verification Successful');
        }
        else{
            return back()->with('error','Invalid Verification Code');
        }
    }


    function signin(Request $request){
        $request->validate([
            'email'=> 'required',
            'password'=> 'required',
        ]);
        $dataEmail = VisitorModel::where('email',$request->email)->first();

        if(VisitorModel::where('email',$request->email)->exists()){

            if(Hash::check($request->password,$dataEmail->password)){

                if(Auth::guard('visitor')->attempt(['email'=>$request->email, 'password'=>$request->password, 'verified'=>'verify'])){
                    return redirect()->route('index');
                }
                else{
                    return redirect()->route('verification',$dataEmail->unique_id);
                }
            }
            else{
                return back()->with('password',"Wrong Password" );
            }

        }
        else{
            return back()->with('email',"Email Does Not Exists" );
        }

    }


    function visitor_logout(){
        Auth::guard("visitor")->logout();
        return redirect()->route("index");
    }


    function forget_pass(Request $request){
        $request->validate([
            "email"=> "required|email",
        ]);

       if(VisitorModel::where("email",$request->email)->exists()){
            $code = random_int('00000', '99999');
            $id = uniqid();
            $visitor = VisitorModel::where("email",$request->email)->first();
            $visitor->update([
                "reset_code"=> $code,
                "pass_reset_id"=> $id,
            ]);

            Mail::to($request->email)->send(new ForgetPassMail($code));

            return redirect()->route('forget.pass', $id)->with('success', 'Code Sent to your email');
       }
       else{
        return back()->with("error","Email Does Not Exists");
       }
    }


    function forget_code_check(Request $request, $id){
        $request->validate([
            "code"=> "required",
        ]);

        if(VisitorModel::where("pass_reset_id",$id)->exists()){
            $code = VisitorModel::where("pass_reset_id",$id)->first();
            if($code->reset_code == $request->code){

                $change_pass = uniqid();
                $code->update([
                    'change_pass'=>$change_pass,
                ]);

                return redirect()->route('pass.reset', $change_pass)->with('success','Change Your Password');

            }
            else{
                return back()->with('error','Invalid Verification Code');
            }
        }
        else{
            return redirect()->route("signin");
        }


    }

    function pass_changed(Request $request, $change_pass){
        $request->validate([
            "password"=> "required",
            'password_confirmation'=>['required', 'same:password'],
        ]);

        $visitor = VisitorModel::where('change_pass',$change_pass)->first();
        $visitor->update([
            'password'=> bcrypt($request->password),
            'pass_reset_id'=>'',
            'reset_code'=>'',
            'change_pass'=>'',
        ]);
        return redirect()->route('signin')->with('success', 'Your Password Changed Successfully');
    }


    function profileChange(Request $request){

        if($request->name == ''){
            return back()->with('error','Name Field is Required');
        }
        else{
            VisitorModel::where('id',Auth::guard('visitor')->user()->id)->update([
                'name'=> $request->name,
            ]);
            return back()->with('success','Name Changed Successfully');
        }

    }


    function profilePassChange(Request $request){
        $request->validate([
            "current_password"=> "required",
            "password"=> "required",
            'password_confirmation'=>['required', 'same:password'],
        ]);

        $data = VisitorModel::where('id',Auth::guard('visitor')->user()->id)->first();
        if(Hash::check($request->current_password,$data->password)){

            VisitorModel::where('id',Auth::guard('visitor')->user()->id)->update([
                'password'=> bcrypt($request->password),
            ]);
            return back()->with('success','Password Changed Successfully');

        }
        else{
            return back()->with('current_password','Current password is Wrong');
        }


    }





}
