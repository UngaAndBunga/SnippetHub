<?php

namespace App\Livewire;
use App\Models\UserPost;

use Livewire\Component;

class Search extends Component
{
    public $helpme;

    public function render()
    {
//        $searchResults = UserPost::where('post_name', 'like', '%' . $this->search . '%')->get()->toArray();
        $searchResults = [];

        return view('livewire.search', compact('searchResults'));
    }
}
