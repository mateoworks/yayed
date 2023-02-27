<?php

namespace App\Http\Livewire\Colonia;

use App\Models\Colonia;
use Livewire\Component;

class ColoniasForm extends Component
{
    public Colonia $colonia;
    public function rules()
    {
        return [
            'colonia.name' => ['required'],
        ];
    }
    public function mount(Colonia $colonia)
    {
        $this->colonia = $colonia;
    }

    public function save()
    {
        $this->validate();
        $this->colonia->save();
        $this->redirectRoute('colonia.index');
    }

    public function render()
    {
        return view('livewire.colonia.colonias-form');
    }
}
