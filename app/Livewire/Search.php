<?php
namespace App\Livewire;

use App\Models\UserPost;
use App\Models\User;
use App\Models\post_tags;
use App\Models\tags;
use Livewire\Component;

class Search extends Component
{
    public $search;

    public function render()
    {
        $searchResults = collect();  // Use collect() to initialize an empty collection
        $postTags = [];
        $userResults = collect();  // Use collect() to initialize an empty collection

        if (!empty($this->search)) {
            // Fetch search results as Eloquent collections
            $searchResults = UserPost::where('post_name', 'like', '%' . $this->search . '%')->get();

            foreach ($searchResults as $post) {
                $postId = $post->id;
                $tagIds = post_tags::where('post_id', $postId)->pluck('tag_id')->toArray();
                $tags = tags::whereIn('id', $tagIds)->pluck('tag_name')->toArray();
                $postTags[$postId] = $tags; // Store tags associated with the post ID
            }

            // Fetch user results as Eloquent collections
            $userResults = User::where('name', 'like', '%' . $this->search . '%')->get();
        }

        return view('livewire.search', [
            'searchResults' => $searchResults->toArray(),  // Convert to array for the view
            'postTags' => $postTags,
            'userResults' => $userResults->toArray()  // Convert to array for the view
        ]);
    }
}
