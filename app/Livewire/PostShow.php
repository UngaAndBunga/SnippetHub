<?php

namespace App\Livewire;
use Livewire\Attributes\Layout;

use App\Models\UserPost;
use App\Models\post_tags;
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
        $tagIds = $this->post->postsTags()->pluck('tag_id')->toArray();
        $this->tags = tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
    }

    public function render()
    {
        return view('livewire.post-show')->layout('layouts.post');
    }
}
