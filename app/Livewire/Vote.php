<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VoteModel;
use Illuminate\Support\Facades\Auth;

class Vote extends Component
{
    public $post;
    public int $votes_percent = 0;

    public function mount($post)
    {
        $this->post = $post;
        $this->updateVotesPercent();
    }

    public function vote($type)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return;
        }

        $userId = Auth::id();

        // Check if the user has already voted for this post
        $vote = VoteModel::where('user_id', $userId)->where('post_id', $this->post->id)->first();

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
            VoteModel::create([
                'user_id' => $userId,
                'post_id' => $this->post->id,
                'vote_type' => $type,
            ]);
        }

        // Update the votes percentage
        $this->updateVotesPercent();
    }

    private function updateVotesPercent()
    {
        $totalVotes = VoteModel::where('post_id', $this->post->id)->count();
        $positiveVotes = VoteModel::where('post_id', $this->post->id)->where('vote_type', 'positive')->count();

        if ($totalVotes > 0) {
            $this->votes_percent = ($positiveVotes / $totalVotes) * 100;
        } else {
            $this->votes_percent = 0;
        }
    }

    public function render()
    {
        $this->updateVotesPercent();
        return view('livewire.vote', ['votes_percent' => $this->votes_percent]);
    }
}
