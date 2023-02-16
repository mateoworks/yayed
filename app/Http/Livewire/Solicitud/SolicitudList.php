<?php

namespace App\Http\Livewire\Solicitud;

use App\Exports\SolicitudsExport;
use App\Models\Solicitud;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

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


    public function exportExcel()
    {
        return Excel::download(
            new SolicitudsExport(),
            Carbon::now()->format('Y_m_d') . '-solicitudes.xlsx'
        );
    }

    public function destroySolicitud(Solicitud $solicitud)
    {
        try {
            if ($solicitud->warranties->isNotEmpty()) {
                foreach ($solicitud->warranties as $warranty) {
                    if ($warranty->url_document) {
                        if (Storage::disk('public')->exists($warranty->url_document)) {
                            Storage::disk('public')->delete($warranty->url_document);
                        }
                    }
                }
            }
            $solicitud->delete();
            $message = 'Se eliminó correctamente la solicitud y sus datos';
            $color = '00ab55';
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getCode() . ' Ocurrio algún problema en la eliminación, consulte con algun ser supremo';
            $color = 'ff3333';
        }
        $this->dispatchBrowserEvent('message', ['message' => $message, 'backgroundColor' => $color]);
    }
}
