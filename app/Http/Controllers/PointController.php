<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentInfoModel;
use App\Models\PayoutRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    function payment(){
        if(Auth::user()->roll == 'admin'){

        $requests = PayoutRequest::all();
        $points = PaymentInfoModel::all();
        $payoutHistories = Payment::all();
        return view('backend.point.payment', compact('points', 'requests', 'payoutHistories'));
    }
    else{
        return redirect()->route('unauthorized');
    }
    }
    function payout(){
        $requests = PayoutRequest::where('user_id', Auth::user()->id)->get();
        $points = PaymentInfoModel::where('user_id', Auth::user()->id)->first();
        $payoutHistories = Payment::where('user_id', Auth::user()->id)->get();
        return view('backend.point.payout', compact('points', 'requests', 'payoutHistories'));
    }

    function payoutRequest(Request $request){
        $request->validate([
            'point'=>'required',
            'method'=>'required',
            'number'=>'required',
        ]);


        $point = PaymentInfoModel::where('user_id', Auth::user()->id)->first();
        if($point->point < $request->point){
            return back()->with('error_message','Insufficient Point' );
        }
        else{
            if($request->point < '100'){
                return back()->with('error_message','100 points is the minimum required' );
            }
            else{

                PayoutRequest::create([
                    'user_id'=>Auth::user()->id,
                    'point'=>$request->point,
                    'method'=>$request->method,
                    'number'=>$request->number,
                ]);
                PaymentInfoModel::where('user_id', Auth::user()->id)->decrement('point', $request->point);

                return back()->with('success','Payout Request Sended Successfully' );
            }
        }
    }

    function pay(Request $request, $id){
        if($request->last_digit == ''){
            return back()->with('error', 'Last Digit Not Found');
        }

        $payout_req = PayoutRequest::find($id);
        $rate = PaymentInfoModel::where('user_id', $payout_req->user_id)->first()->rate;
        Payment::create([
            'user_id'=>$payout_req->user_id,
            'amount'=>$payout_req->point * $rate,
            'pay_number'=>$payout_req->number,
            'pay_method'=>$payout_req->method,
            'last_digit'=>$request->last_digit,
            'note'=>$request->note,
        ]);
        $payout_req->delete();

        return back()->with('success','Payment Successfully' );
    }

    function rate_update(Request $request, $id){
        $request->validate([
            'rate'=>'required'
        ]);

        PaymentInfoModel::find($id)->update([
            'rate'=>$request->rate,
        ]);
        return back()->with('success','Rate Update Successfully' );
    }
}
