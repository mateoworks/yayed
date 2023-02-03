<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class UsersShow extends Component
{
    public User $user;
    public function render()
    {
        return view('livewire.user.users-show', [
            'user' => $this->user,
        ]);
    }
}
