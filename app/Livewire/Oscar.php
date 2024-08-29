<?php

namespace App\Livewire;

use App\Models\MovieModel;
use Livewire\Component;
use Livewire\WithPagination;

class Oscar extends Component
{
    use WithPagination;

    public function render()
    {
        $oscars = MovieModel::where('oscar', 1)->latest()->paginate(30);
        return view('livewire.oscar',[
            'oscars'=>$oscars,
        ]);
    }
}
