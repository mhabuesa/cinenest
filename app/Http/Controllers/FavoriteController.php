<?php

namespace App\Http\Controllers;

use App\Models\FavoriteModel;
use App\Models\MovieModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function favorite_store(Request $request)
    {

        $movieId = $request->input('movie_id');
        $userId = Auth::guard('visitor')->user()->id;

        // Check if the favorite already exists
        $favorite = FavoriteModel::where('movie_id', $movieId)->where('visitor_id', $userId)->first();

        if ($favorite) {
            // If it exists, remove it (unfavorite)
            $favorite->delete();
            $status = 'removed';
        } else {
            // If it doesn't exist, create it (favorite)
            $favorite = new FavoriteModel();
            $favorite->movie_id = $movieId;
            $favorite->visitor_id = $userId;
            $favorite->save();
            $status = 'added';
        }

        return response()->json(['success' => true, 'status' => $status, 'message' => 'Favorite status updated']);
    }


    function favorite_toggle($id){

        $movieId = $id;
        $userId = Auth::guard('visitor')->user()->id;

        // Check if the favorite already exists
        $favorite = FavoriteModel::where('movie_id', $movieId)->where('visitor_id', $userId)->first();

        if ($favorite) {
            // If it exists, remove it (unfavorite)
            $favorite->delete();
        } else {
            // If it doesn't exist, create it (favorite)
            $favorite = new FavoriteModel();
            $favorite->movie_id = $movieId;
            $favorite->visitor_id = $userId;
            $favorite->save();
        }
        return back()->with([
            'favorite'=>$favorite,
        ]);
    }
}
