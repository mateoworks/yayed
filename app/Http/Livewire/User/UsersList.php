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
        try {
            $user->delete();
            $message = 'Se eliminó el usuario correctamente';
            $backgroundColor = '00ab55';
        } catch (\Exception $e) {
            $message = 'Error código: ' . $e->getCode() . ', tiene algún dato relacionado con pagos.';
            $backgroundColor = 'ff3333';
        }
        $this->dispatchBrowserEvent('message', ['message' => $message, 'backgroundColor' => $backgroundColor]);
    }
}
