<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Followers;

class FollowButton extends Component
{
    public $userId;
    public $isFollowing;

    public function mount($userId)
    {
        $this->userId = $userId;
        $this->isFollowing = Followers::where('follower_id', Auth::id())->where('followee_id', $this->userId)->exists();
    }

    public function follow()
    {
        if ($this->isFollowing) {
            Followers::where('follower_id', Auth::id())->where('followee_id', $this->userId)->delete();
            $this->isFollowing = false;
        } else {
            Followers::create([
                'follower_id' => Auth::id(),
                'followee_id' => $this->userId
            ]);
            $this->isFollowing = true;
        }
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
