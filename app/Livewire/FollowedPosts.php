<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\UserPost;
use App\Models\tags;

class FollowedPosts extends Component
{
    public $followedPosts;
    public $followedUsers;
    public $tags;

    public function mount()
    {
        $this->followedUsers = Auth::user()->followees;
        $this->followedPosts = collect();
        $this->tags = collect();

        foreach ($this->followedUsers as $followedUser) {
            $posts = UserPost::where('post_owner', $followedUser->id)->get();
            $this->followedPosts = $this->followedPosts->merge($posts);

            foreach ($posts as $post) {
                $tagIds = $post->postsTags()->pluck('tag_id')->toArray();
                $tags = tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                $this->tags = $this->tags->merge($tags);
            }
        }

        // Remove duplicate tags if necessary
        $this->tags = $this->tags->unique();
    }

    public function render()
    {
        return view('livewire.followed-posts', [
            'followedPosts' => $this->followedPosts,
            'tags' => $this->tags,
        ]);
    }
}
