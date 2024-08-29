<?php

namespace App\Livewire;

use App\Models\MovieModel;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class Search extends Component
{
    use WithPagination;
    public function render(Request $request)
    {

        $data = $request->all();
        $movies = MovieModel::where(function ($q) use ($data){

            if(!empty($data['key']) && $data['key'] != '' && $data['key'] != 'undefined'){
                $q->where(function ($q) use ($data){
                    $q->where('title','like', '%' .$data['key'].'%');
                    // $q->orWhere('desp','like', '%' .$data['key'].'%');
                    // $q->orWhere('story_line','like', '%' .$data['key'].'%');
                    $q->orWhere('keyword','like', '%' .$data['key'].'%');
                });
            }
        })->paginate(30);
        return view('livewire.search',[
            'movies'=>$movies,
        ]);

    }
}
