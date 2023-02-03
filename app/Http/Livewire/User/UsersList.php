<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Livewire\Component;

class UsersList extends Component
{
    //protected $listeners = ['destroy'];

    public function render()
    {
        $users = User::latest()->paginate();
        return view('livewire.user.users-list', ['users' => $users]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('message', 'Se eliminó el usuario correctamente');
    }
}
