<?php

namespace App\Http\Livewire\Loan;

use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class LoansContract extends Component
{
    public Loan $loan;
    public function render()
    {
        return view('livewire.loan.loans-contract', [
            'loan' => $this->loan
        ]);
    }
    public function exportPDF()
    {
        $data = [
            'loan' => $this->loan,
        ];
        $pdf = Pdf::loadView('pdf-template.contrato-prestamo', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-contrato_' . $this->loan->number . '.pdf');
    }
}
