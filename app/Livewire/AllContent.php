<?php

namespace App\Livewire;

use App\Models\MovieModel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoriteModel;

class AllContent extends Component
{
    use WithPagination;

    public $id;


    public function favorite($id)
    {
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
    }


    public function render()
    {
        $movies = MovieModel::latest()->paginate(30);
        return view('livewire.all-content',[
            'movies'=>$movies,
        ]);
    }
}
