<?php

namespace App\Http\Controllers;

use App\Models\MovieModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{

    function features(){

        if(Auth::user()->roll == 'admin' || Auth::user()->roll == 'moderator'){
            $movies = MovieModel::all();
            return view('backend.features.features', [
                'movies'=>$movies,
            ]);
           }
           else{
            return redirect()->route('dashboard');
           }
    }



    public function oscar_status(Request $request){
        $oscar = MovieModel::find($request->id)->oscar;
        if($oscar == 0){
            MovieModel::find($request->id)->update([
                'oscar'=>1,
            ]);
            return response()->json(['success' => true, 'message' => 'Oscar Status updated successfully.']);
        }

        else{
            MovieModel::find($request->id)->update([
                'oscar'=>0,
            ]);
            return response()->json(['success' => true, 'message' => 'Oscar Status updated successfully.']);
        }


        return response()->json(['success' => false, 'message' => 'Status not updated.']);
    }


    public function supper_status(Request $request){

        $supper_hit = MovieModel::find($request->id)->supper_hit;
        $active = MovieModel::where('supper_hit', 1)->get();



            if($supper_hit == 0){

                if($active->count() >= 10){
                    return response()->json(['success' => false, 'message' => 'Status not updated.']);
                }
                else{
                    MovieModel::find($request->id)->update([
                        'supper_hit'=>1,
                    ]);
                    return response()->json(['success' => true, 'message' => 'Supper Hit Status updated successfully.']);
                }

            }

            else{

                if($active->count() <= 5){
                    return response()->json(['success' => false, 'message' => 'Status not updated.']);
                }
                else{
                    MovieModel::find($request->id)->update([
                        'supper_hit'=>0,
                    ]);
                    return response()->json(['success' => true, 'message' => 'Supper Hit Status updated successfully.']);
                }



            }






    }
}
