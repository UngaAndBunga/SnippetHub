<?php

namespace App\Livewire;

use App\Models\PostTags;
use App\Models\Tags;
use App\Models\UserPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class TrendingPosts extends Component
{
    public array $postsWithTags = [];

    /**
     * @throws \JsonException
     */
    public function mount(): void
    {
        $posts = UserPost::all();

        foreach ($posts as $post) {
            // Get all tag IDs associated with the current post
            $tagIds = (new PostTags)->where('post_id', $post->id)->pluck('tag_id');

            // Get tag names for these tag IDs
            $tags = Tags::whereIn('id', $tagIds)->pluck('tag_name');

            // Add the post and its tags to the array
            $this->postsWithTags[] = [
                'post' => $post,
                'tags' => $tags,
            ];
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.trending-posts', ['postsWithTags' => $this->postsWithTags]);
    }
}
