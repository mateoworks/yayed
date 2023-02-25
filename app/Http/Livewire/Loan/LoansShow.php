<?php

namespace App\Http\Livewire\Loan;

use App\Helpers\Amortizacion;
use App\Models\Endorsement;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\Solicitud;
use App\Models\Warranty;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class LoansShow extends Component
{
    public Loan $loan;
    public Solicitud $solicitud;
    public function render()
    {
        return view('livewire.loan.loans-show', [
            'loan' => $this->loan
        ]);
    }

    public function mount()
    {
        $this->solicitud = $this->loan->solicitud;
    }

    public function constanciaAval()
    {
        $amortizacion = new Amortizacion($this->loan);
        $data = [
            'loan' => $this->loan,
            'endorsements' => $this->loan->solicitud->endorsements,
            'periodo' => $amortizacion->periodos,
            'pago' => $amortizacion->pagoMensual,
        ];
        $pdf = Pdf::loadView('pdf-template.constancia-aval', $data)->setPaper('letter');
        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-constancia-aval_' . $this->loan->number . '.pdf');
    }

    public function pagare()
    {
        $amortizacion = new Amortizacion($this->loan);

        $data = [
            'loan' => $this->loan,
            'partner' => $this->loan->partner,
            'amortizacion' => $amortizacion->amortizacion,
            'pago' => $amortizacion->pagoMensual,
            'sumInteres' => $amortizacion->sumInteres,
            'sumAmortizacion' => $amortizacion->sumAmortizacion,
            'avales' => $this->loan->solicitud->endorsements,
            'garantias' => $this->loan->solicitud->warranties,
            'periodos' => $amortizacion->periodos,
        ];
        $pdf = Pdf::loadView('pdf-template.pagare', $data)
            ->set_option("isPhpEnabled", true)
            ->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-pagare_' . $this->loan->number . '.pdf');
    }

    /* Quit endorsement, but not delete */
    public function quitEndorsement(Endorsement $endorsement)
    {
        $this->solicitud->endorsements()->detach($endorsement);
        $this->loan->refresh();
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
        $this->loan->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó la garantía']);
    }

    public function destroyPayment(Payment $payment)
    {
        $payment->delete();
        $this->loan->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminaron los datos del pago']);
    }
}
