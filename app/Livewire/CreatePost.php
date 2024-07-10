<?php

namespace App\Livewire;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\UserPost;
use App\Models\tags;
use App\Models\post_tags;
use Illuminate\Support\Facades\Auth;

class CreatePost extends Component
{
    public $post_name = '';
    public $post_content = '';
    public $tags = '';
    public $tagSuggestions = [];
    public $selectedTags = [];
    public $maxTags = 5;
    public $new_post_id;


    public function render()
    {
        return view('livewire.create-post')->layout(\App\View\Components\AppLayout::class);
    }

    public function updatedTags($tags)
    {
        $this->tagSuggestions = tags::where('tag_name', 'like', '%' . $tags . '%')
                                   ->distinct()
                                   ->pluck('tag_name')
                                   ->toArray();
    }

    public function selectTag($tagName)
    {
        if (count($this->selectedTags) < $this->maxTags) {
            $this->selectedTags[] = $tagName;
            $this->tags = ''; // Clear the input field after selecting a tag
            $this->tagSuggestions = [];
        }
    }

    public function removeTag($index)
    {
        unset($this->selectedTags[$index]);
        $this->selectedTags = array_values($this->selectedTags); // Re-index the array
    }
    public function save()
    {   
        $post_owner = Auth::id();
        

        $post = UserPost::create([
            'post_name' => $this->post_name,
            'post_content' => $this->post_content,
            'post_owner'=> $post_owner,
            'timestamp' => now()
        ]);
        $new_post_id = $post->id;
       
        $tagsArray = array_map('trim', explode(',', $this->tags));

        foreach ($tagsArray as $tagName) {
            $tag = tags::firstOrCreate(['tag_name' => $tagName]);
            $new_tag_id = tags::where('tag_name', $tagName)->first();
            $new_tag_id = $new_tag_id->id;
            post_tags::create([
                'post_id'=> $new_post_id,
                'tag_id' => $new_tag_id
            ]);
            
        }
       
       
        $this->reset(['post_name', 'post_content', 'tags', 'selectedTags']);
        // Flash a success message
        session()->flash('message', 'Post successfully created.');
    }
    
}
