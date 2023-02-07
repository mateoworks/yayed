<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\Solicitud;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class SolicitudShow extends Component
{
    public Solicitud $solicitud;
    public function render()
    {
        return view('livewire.solicitud.solicitud-show', [
            'solicitud' => $this->solicitud,
        ]);
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
