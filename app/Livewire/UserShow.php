<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\UserPost;
use Livewire\Component;

class UserShow extends Component
{
    public $userId;

    public $user;

    public $posts;

    /**
     * @throws \JsonException
     */
    public function mount($id)
    {
        $this->userId = $id;
        $this->user = \Auth::user();
        $this->posts = (new UserPost)->where('post_owner', $id);
    }

    public function render()
    {
        // Determine the appropriate layout based on user authentication status
        $layout = auth()->check() ? 'layouts.app' : 'layouts.post';

        // Return the view with the selected layout

        return view('livewire.user-show', [
            'user' => $this->user,
            'posts' => $this->posts,
        ])->layout('layouts.post')->layout($layout);

    }
}
