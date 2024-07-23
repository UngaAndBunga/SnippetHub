<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowedUsers extends Component
{
    public $followedUsers;

    public function mount()
    {
        $this->followedUsers = Auth::user()->followees; // Assumes you have defined a followees relationship in the User model
    }

    public function render()
    {
        return view('livewire.followed-users', [
            'followedUsers' => $this->followedUsers,
        ]);
    }
}
