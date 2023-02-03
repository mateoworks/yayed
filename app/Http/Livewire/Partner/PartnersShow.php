<?php

namespace App\Http\Livewire\Partner;

use App\Models\Partner;
use Livewire\Component;

class PartnersShow extends Component
{
    public Partner $partner;
    public function render()
    {
        return view('livewire.partner.partners-show', [
            'partner' => $this->partner,
        ]);
    }
}
