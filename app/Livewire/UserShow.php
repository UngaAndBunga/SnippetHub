<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\UserPost;
class UserShow extends Component
{
   
    public $userId;
    public $user;
    public $posts;

    public function mount($id)
    {
        $this->userId = $id;
        $this->user = User::find($id);
        $this->posts = UserPost::where('post_owner', $id)->get();
    }
        public function render()
        {
            return view('livewire.user-show', [
                'user' => $this->user,
                'posts' => $this->posts
            ])->layout('layouts.post');
        }
}
    
