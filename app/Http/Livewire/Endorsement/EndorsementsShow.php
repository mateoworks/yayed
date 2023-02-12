<?php

namespace App\Http\Livewire\Endorsement;

use App\Models\Endorsement;
use Livewire\Component;

class EndorsementsShow extends Component
{
    public Endorsement $endorsement;
    public function render()
    {
        return view('livewire.endorsement.endorsements-show', [
            'endorsement' => $this->endorsement,
            'loans' => $this->endorsement->solicituds,
        ]);
    }
}
