<?php

namespace App\Livewire;

use App\Models\tags;
use App\Models\User;
use App\Models\UserPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Search extends Component
{
    public $search;

    /**
     * @throws \JsonException
     */
    public function render(): View|Application|Factory
    {
        $searchResults = collect();  // Use collect() to initialize an empty collection
        $postTags = [];
        $userResults = collect();  // Use collect() to initialize an empty collection

        if (! empty($this->search)) {
            // Fetch search results as Eloquent collections
            $searchResults = (new UserPost)->where('post_name', 'like', '%'.$this->search.'%')->get();

            foreach ($searchResults as $post) {
                $postId = $post->id;
                $tagIds = (new \App\Models\PostTags)->where('post_id', $postId)->pluck('tag_id')->toArray();
                $tags = Tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                $postTags[$postId] = $tags; // Store tags associated with the post ID
            }

            // Fetch user results as Eloquent collections
            $userResults = User::where('name', 'like', '%'.$this->search.'%')->get();
        }

        return view('livewire.search', [
            'searchResults' => $searchResults->toArray(),  // Convert to array for the view
            'postTags' => $postTags,
            'userResults' => $userResults->toArray(),  // Convert to array for the view
        ]);
    }
}
