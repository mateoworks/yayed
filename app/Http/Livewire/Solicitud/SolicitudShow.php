<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\Endorsement;
use App\Models\Solicitud;
use App\Models\Warranty;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class SolicitudShow extends Component
{
    public Solicitud $solicitud;
    public function render()
    {
        return view('livewire.solicitud.solicitud-show', [
            'solicitud' => $this->solicitud,
        ]);
    }

    public function autorizar()
    {
        $this->solicitud->condition = 'autorizado';
        $this->solicitud->save();
    }
    /* Quit endorsement, but not delete */
    public function quitEndorsement(Endorsement $endorsement)
    {
        $this->solicitud->endorsements()->detach($endorsement);
        $this->solicitud->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se ha desvinculado con el aval']);
    }
    /* Destroy warranty */
    public function destroyWarranty(Warranty $warranty)
    {
        if ($warranty->url_document) {
            if (Storage::disk('public')->exists($warranty->url_document)) {
                Storage::disk('public')->delete($warranty->url_document);
            }
        }
        $warranty->delete();
        $this->solicitud->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó la garantía']);
    }

    public function exportPDF()
    {
        $data = [
            'solicitud' => $this->solicitud,
            'partner' => $this->solicitud->partner,
        ];
        $pdf = Pdf::loadView('pdf-template.solicitud-prestamo', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-solicitud_' . $this->solicitud->folio . '.pdf');
    }
}
