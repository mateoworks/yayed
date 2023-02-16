<?php

namespace App\Http\Livewire\Payments;

use App\Exports\PaymentsExport;
use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class PaymentList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public function render()
    {
        return view('livewire.payments.payment-list', [
            'payments' => Payment::latest('scheduled_date')->paginate(),
        ]);
    }

    public function destroyPayment(Payment $payment)
    {
        $payment->delete();
        $this->dispatchBrowserEvent('message', [
            'message' => 'Se eliminó correctamente este socio',
            'backgroundColor' => '00ab55'
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(
            new PaymentsExport(),
            Carbon::now()->format('Y_m_d') . '-pagos.xlsx'
        );
    }
}
