<?php

namespace App\Http\Livewire\Payments;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

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
}
