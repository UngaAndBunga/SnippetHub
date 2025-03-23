<?php

namespace App\Livewire;

use App\Models\Tags;
use App\Models\UserPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowedPosts extends Component
{
    public $followedPosts;

    public $followedUsers;

    public $tags;

    /**
     * @throws \JsonException
     */
    public function mount()
    {
        $this->followedUsers = Auth::user()->followees;
        $this->followedPosts = collect();
        $this->tags = collect();

        foreach ($this->followedUsers as $followedUser) {
            $posts = (new UserPost)->where('post_owner', $followedUser->id)->get();
            $this->followedPosts = $this->followedPosts->merge($posts);

            foreach ($posts as $post) {
                $tagIds = $post->postsTags()->pluck('tag_id')->toArray();
                $tags = Tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                $this->tags = $this->tags->merge($tags);
            }
        }

        // Remove duplicate tags if necessary
        $this->tags = $this->tags->unique();
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.followed-posts', [
            'followedPosts' => $this->followedPosts,
            'tags' => $this->tags,
        ]);
    }
}
