<?php

namespace App\Livewire;

use App\Models\PostVotes;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Vote extends Component
{
    public $post;

    public int $votes_percent = 0;

    /**
     * @throws \JsonException
     */
    public function mount($post)
    {
        $this->post = $post;
        $this->updateVotesPercent();
    }

    /**
     * @throws \JsonException
     */
    public function vote($type): void
    {
        // Check if user is authenticated
        if (! Auth::check()) {
            return;
        }

        $userId = Auth::id();

        // Check if the user has already voted for this post
        $vote = (new PostVotes)->where('user_id', $userId)->where('post_id', $this->post->id)->first();

        if ($vote) {
            // If the vote type is the same, remove the vote
            if ($vote->vote_type === $type) {
                $vote->delete();
            } else {
                // Update the vote type
                $vote->vote_type = $type;
                $vote->save();
            }
        } else {
            PostVotes::create([
                'user_id' => $userId,
                'post_id' => $this->post->id,
                'vote_type' => $type,
            ]);
        }

        // Update the votes percentage
        $this->updateVotesPercent();
    }

    /**
     * @throws \JsonException
     */
    private function updateVotesPercent(): void
    {
        $voteModel = new PostVotes;
        $totalVotes = $voteModel->where('post_id', $this->post->id)->count();
        $positiveVotes = $voteModel->where('post_id', $this->post->id)->where('vote_type', 'positive')->count();

        if ($totalVotes > 0) {
            $this->votes_percent = ($positiveVotes / $totalVotes) * 100;
        } else {
            $this->votes_percent = 0;
        }
    }

    /**
     * @throws \JsonException
     */
    public function render(): View|Application|Factory
    {
        $this->updateVotesPercent();

        return view('livewire.vote', ['votes_percent' => $this->votes_percent]);
    }
}
