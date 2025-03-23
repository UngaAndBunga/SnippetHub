<?php

namespace App\Livewire;

use App\Models\Followers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FollowButton extends Component
{
    public int $userId;

    public bool $isFollowing;

    /**
     * @throws \JsonException
     */
    public function mount($userId): void
    {
        $this->userId = $userId;
        $this->isFollowing = (new Followers)->where('follower_id', Auth::id())->where('followee_id', $this->userId)->exists();
    }

    /**
     * @throws \JsonException
     */
    public function follow(): void
    {
        if ($this->isFollowing) {
            (new Followers)->where('follower_id', Auth::id())->where('followee_id', $this->userId)->delete();
            $this->isFollowing = false;
        } else {
            Followers::create([
                'follower_id' => Auth::id(),
                'followee_id' => $this->userId,
            ]);
            $this->isFollowing = true;
        }
    }

    public function render()
    {
        return view('livewire.follow-button');
    }
}
