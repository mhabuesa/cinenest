<?php

namespace App\Livewire;

use App\Models\MovieModel;
use Livewire\Component;

class Features extends Component
{
    public function oscar($id){
        $oscar = MovieModel::find($id)->oscar;
        if($oscar == 0){
            MovieModel::find($id)->update([
                'oscar'=>1,
            ]);
        }

        else{
            MovieModel::find($id)->update([
                'oscar'=>0,
            ]);
        }

        return back();
    }


    public function supper_hit($id){
        $supper_hit = MovieModel::find($id)->supper_hit;
        if($supper_hit == 0){
            MovieModel::find($id)->update([
                'supper_hit'=>1,
            ]);
        }

        else{
            MovieModel::find($id)->update([
                'supper_hit'=>0,
            ]);
        }

        return back();
    }


    public function render()
    {
        $movies = MovieModel::all();
        return view('livewire.features', [
            'movies'=>$movies,
        ]);
    }
}
