<?php

namespace App\Livewire;

use App\Models\Tags;
use App\Models\UserPost;
use Livewire\Component;

class PostShow extends Component
{
    /**
     * @var UserPost
     */
    public UserPost $post;

    public array $tags = [];

    public function mount($id): void
    {
        $this->post = UserPost::findOrFail($id);
        $tagIds = $this->post->postTags()->pluck('tag_id')->toArray();
        $this->tags = Tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
    }

    public function render()
    {
        $layout = auth()->check() ? 'layouts.guest' : 'layouts.post';

        // Return the view with the selected layout
        return view('components.post-show')->layout($layout)->with([$this->tags, $this->post]);
    }
}
