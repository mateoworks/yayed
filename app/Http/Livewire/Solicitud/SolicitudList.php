<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\Solicitud;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class SolicitudList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = '';

    public function render()
    {
        $searched = $this->search;
        return view('livewire.solicitud.solicitud-list', [
            'solicitudes' => Solicitud::where('condition', 'like', "%$this->status%")
                ->with('partner')
                ->whereHas('partner', function ($q) use ($searched) {
                    $q->where(DB::raw("CONCAT(names, ' ', surname_father, ' ', surname_mother)"), 'like', "%$searched%");
                })
                ->latest('date_solicitud')
                ->paginate(),
        ]);
    }
}
