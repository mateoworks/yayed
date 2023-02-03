<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class UsersForm extends Component
{
    use WithFileUploads;
    public User $user;

    public $image;
    public $password;

    protected function rules()
    {
        return [
            'user.name' => ['required', 'min:3', 'alpha_spaces'],
            'user.surname' => ['required', 'min:3', 'alpha_spaces'],
            'user.email' => [
                'required',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'user.job' => ['required'],
            'password' => [
                Rule::requiredIf(!isset($this->user->id)),
                'min:6',
                'nullable'
            ],
            'image' => ['nullable', 'image', 'max:2024']
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function save()
    {
        $this->validate();
        if ($this->image) {
            $this->user->image = $this->image->store('/perfil_user', 'public');
        }
        if ($this->password) {
            $this->user->password = Hash::make($this->password);
        }
        $this->user->save();
        Session::flash('message', 'Usuario guardado exitosamente');
        Session::flash('alert_class', 'success');
        $this->redirectRoute('users.index');
    }

    public function deleteImg()
    {
        Storage::disk('public')->delete($this->user->image);
        $this->user->image = '';
        $this->user->save();
    }

    public function render()
    {
        return view('livewire.user.users-form');
    }
}
