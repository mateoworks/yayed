<?php

namespace App\Http\Livewire\Partner;

use App\Models\Partner;
use Livewire\Component;
use Livewire\WithPagination;

class PartnersList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function render()
    {
        return view('livewire.partner.partners-list', [
            'partners' => Partner::where('names', 'like', "%$this->search%")
                ->orWhere('surname_father', 'like', "%$this->search%")
                ->orWhere('surname_mother', 'like', "%$this->search%")
                ->orWhere('curp', 'like', "%$this->search%")
                ->latest()
                ->paginate(),
        ]);
    }

    public function destroy(Partner $partner)
    {
        $partner->delete();
    }
}
