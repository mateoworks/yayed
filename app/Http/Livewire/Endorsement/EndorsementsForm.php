<?php

namespace App\Http\Livewire\Endorsement;

use App\Models\Endorsement;
use Livewire\Component;

class EndorsementsForm extends Component
{
    public Endorsement $endorsement;

    public function rules()
    {
        return [
            'endorsement.names' => ['required'],
            'endorsement.surnames' => ['required'],
            'endorsement.phone' => ['nullable'],
            'endorsement.address' => ['nullable'],
            'endorsement.key_ine' => ['nullable'],
        ];
    }
    public function save()
    {
        $this->validate();
        $this->endorsement->save();
        $this->redirectRoute('endorsements.index');
    }
    public function mount(Endorsement $endorsement)
    {
        $this->endorsement = $endorsement;
    }
    public function render()
    {
        return view('livewire.endorsement.endorsements-form', [
            'endorsement' => $this->endorsement,
        ]);
    }
}
