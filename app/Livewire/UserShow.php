<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
class UserShow extends Component
{
   
        public $userId;
        public $user;
    
        public function mount($id)
        {
            $this->userId = $id;
            $this->user = User::find($id);
        }
    
        public function render()
        {
            return view('livewire.user-show', [
                'user' => $this->user,
            ])->layout('layouts.post');
        }
}
    
