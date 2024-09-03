<?php

namespace App\Livewire;

use App\Models\UserPost;
use App\Models\tags;

use Livewire\Component;

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
        $layout = auth()->check() ? 'layouts.guest' : 'layouts.post';
        // Return the view with the selected layout
        return view('components.post')->layout($layout)->with([$this->tags, $this->post]);
    }
}
