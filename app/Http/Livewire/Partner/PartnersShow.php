<?php

namespace App\Http\Livewire\Partner;

use App\Models\Partner;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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

    public function exportPDF()
    {
        $data = [
            'partner' => $this->partner,
        ];
        $pdf = Pdf::loadView('pdf-template.detalle-socio', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-socio-' . $this->partner->number . '.pdf');
    }
}
