<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FollowedUsers extends Component
{
    public $followedUsers;

    public function mount(): void
    {
        $this->followedUsers = Auth::user()->followees; // Assumes you have defined a followees relationship in the User model
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.followed-users', [
            'followedUsers' => $this->followedUsers,
        ]);
    }
}
