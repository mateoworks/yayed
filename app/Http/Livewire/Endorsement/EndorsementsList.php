<?php

namespace App\Http\Livewire\Endorsement;

use App\Models\Endorsement;
use Livewire\Component;
use Livewire\WithPagination;

class EndorsementsList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.endorsement.endorsements-list', [
            'endorsements' => Endorsement::latest()->paginate(),
        ]);
    }

    public function destroyEndorsement(Endorsement $endorsement)
    {
        $endorsement->delete();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó el aval']);
    }
}
