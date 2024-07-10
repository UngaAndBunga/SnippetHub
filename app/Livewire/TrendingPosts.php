<?php

namespace App\Livewire;
use App\Models\UserPost;
use App\Models\tags;
use App\Models\post_tags;
use Livewire\Component;

class TrendingPosts extends Component

{
    public $postsWithTags = [];

    public function mount()
    {
        // Fetch all posts
        $posts = UserPost::all();

        foreach ($posts as $post) {
            // Get all tag IDs associated with the current post
            $tagIds = post_tags::where('post_id', $post->id)->pluck('tag_id');

            // Get tag names for these tag IDs
            $tags = tags::whereIn('id', $tagIds)->pluck('tag_name');

            // Add the post and its tags to the array
            $this->postsWithTags[] = [
                'post' => $post,
                'tags' => $tags
            ];
        }
    }

    public function render()
    {
        return view('livewire.trending-posts', ['postsWithTags' => $this->postsWithTags]);
    }
}


