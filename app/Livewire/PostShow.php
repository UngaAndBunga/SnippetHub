<?php

namespace App\Livewire;

use App\Models\UserPost;
use App\Models\tags;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class PostShow extends Component
{
    public $post;
    public $tags = [];

    public function mount($id)
    {
        $this->post = UserPost::findOrFail($id);
        $tagIds = $this->post->tags()->pluck('id')->toArray();
        $this->tags = tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
    }

    public function render()
    {
        return view('livewire.post-show');
    }
}
