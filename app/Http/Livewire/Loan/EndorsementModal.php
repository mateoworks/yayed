<?php

namespace App\Http\Livewire\Loan;

use App\Models\Endorsement;
use Livewire\Component;

class EndorsementModal extends Component
{
    protected $listeners = [
        'display-modal' => 'toggleModal',
    ];

    public Endorsement $endorsement;

    public function mount(Endorsement $endorsement)
    {
        $this->endorsement = $endorsement;
    }

    public function rules()
    {
        return [
            'endorsement.names' => ['required'],
            'endorsement.surnames' => ['required'],
            'endorsement.phone' => ['nullable'],
        ];
    }

    public function toggleModal()
    {
        $this->dispatchBrowserEvent('show-modal');
    }

    public function hideModal()
    {
        $this->dispatchBrowserEvent('hide-modal');
    }

    public function save()
    {
        $this->validate();
        dd('aqui');
        $this->endorsement->save();
    }
    public function render()
    {
        return view('livewire.loan.endorsement-modal');
    }
}
