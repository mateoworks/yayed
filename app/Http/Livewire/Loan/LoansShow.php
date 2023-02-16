<?php

namespace App\Http\Livewire\Loan;

use App\Models\Endorsement;
use App\Models\Loan;
use App\Models\Payment;
use App\Models\Solicitud;
use App\Models\Warranty;
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
