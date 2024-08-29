<?php

namespace App\Livewire;

use App\Models\InventoryModel;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;

    public $slug;

    public function render()
    {
        $movies = InventoryModel::where('slug' , $this->slug)->latest()->paginate(30);

        return view('livewire.category',[
            'movies'=>$movies,
        ]);
    }
}
