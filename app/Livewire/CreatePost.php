<?php

namespace App\Livewire;

use App\Models\PostTags;
use App\Models\Tags;
use App\Models\UserPost;
use App\View\Components\AppLayout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreatePost extends Component
{
    public string $post_name = '';

    public string $post_content = '';

    public string $tags = '';

    public array $tagSuggestions = [];

    public array $selectedTags = [];

    public int $maxTags = 5;

    public function render()
    {
        return view('livewire.create-post')->layout(AppLayout::class);
    }

    /**
     * @throws \JsonException
     */
    public function updatedTags($tags): void
    {
        $this->tagSuggestions = (new Tags)->where('tag_name', 'like', '%'.$tags.'%')
            ->distinct()
            ->pluck('tag_name')
            ->toArray();
    }

    public function selectTag($tagName): void
    {
        if (count($this->selectedTags) < $this->maxTags) {
            $this->selectedTags[] = $tagName;
            $this->tags = ''; // Clear the input field after selecting a tag
            $this->tagSuggestions = [];
        }
    }

    public function removeTag($index): void
    {
        unset($this->selectedTags[$index]);
        $this->selectedTags = array_values($this->selectedTags);
    }

    /**
     * @throws \JsonException
     */
    public function save(): void
    {
        $post_owner = Auth::id();
        $post = UserPost::create([
            'post_name' => $this->post_name,
            'post_content' => $this->post_content,
            'post_owner' => $post_owner,
            'timestamp' => now(),
        ]);
        $new_post_id = $post->id;

        $tagsArray = array_map('trim', explode(',', $this->tags));

        foreach ($tagsArray as $tagName) {
            $tag = Tags::updateOrCreate(['tag_name' => $tagName]);
            $new_tag_id = (new Tags)->where('tag_name', $tagName)->first();
            $new_tag_id = $new_tag_id->id;
            PostTags::create([
                'post_id' => $new_post_id,
                'tag_id' => $new_tag_id,
            ]);
        }
        $this->reset(['post_name', 'post_content', 'tags', 'selectedTags']);
        // Flash a success message
        session()->flash('message', 'Post successfully created.');
    }
}
