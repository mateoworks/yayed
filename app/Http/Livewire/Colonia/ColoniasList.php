<?php

namespace App\Http\Livewire\Colonia;

use App\Models\Colonia;
use Livewire\Component;

class ColoniasList extends Component
{
    public function destroyColonia(Colonia $colonia)
    {
        $colonia->delete();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó la colonia']);
    }
    public function render()
    {
        return view('livewire.colonia.colonias-list', [
            'colonias' => Colonia::latest()->paginate(),
        ]);
    }
}
