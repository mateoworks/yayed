<?php

namespace App\Http\Livewire\Loan;

use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class LoansDetail extends Component
{
    public Loan $loan;
    public function render()
    {
        return view('livewire.loan.loans-detail', [
            'loan' => $this->loan
        ]);
    }
    public function exportPDF()
    {
        $data = [
            'loan' => $this->loan,
            'solicitud' => $this->loan->solicitud,
        ];
        $pdf = Pdf::loadView('pdf-template.detalle-prestamo', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-detalle_' . $this->loan->number . '.pdf');
    }
}
