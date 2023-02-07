<?php

namespace App\Http\Livewire\Payments;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class PaymentShow extends Component
{
    public Payment $payment;
    public function render()
    {
        return view('livewire.payments.payment-show', [
            'payment' => $this->payment,
        ]);
    }

    public function exportPDF()
    {
        $data = [
            'loan' => $this->payment->loan,
            'payment' => $this->payment,
        ];
        $pdf = Pdf::loadView('pdf-template.comprobante-pago', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-comprobante_' . $this->payment->numero . '.pdf');
    }
}
