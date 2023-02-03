<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    public function render()
    {
        return view('livewire.user.profile', [
            'user' => User::findOrFail(auth()->user()->id),
        ]);
    }
}
