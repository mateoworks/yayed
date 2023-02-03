<?php

namespace App\Http\Livewire\Payments;

use App\Models\Loan;
use App\Models\Payment;
use Carbon\Carbon;
use Livewire\Component;

class PaymentForm extends Component
{
    public Loan $loan;
    public Payment $payment;
    public $last_payment;
    public $numMonth;
    public $status = false;
    protected function rules()
    {
        return [
            'payment.scheduled_date' => ['required', 'date'],
            'payment.made_date' => ['required', 'date'],
            'payment.type' => ['nullable'],
            'payment.social_contribution' => ['nullable'],
            'payment.period' => ['nullable'],
            'payment.concept' => ['nullable'],
            'payment.interest_amount' => ['nullable', 'numeric'],
            'payment.principal_amount' => ['nullable', 'numeric'],
            'payment.other_amount' => ['nullable', 'numeric'],
            'payment.observations' => ['nullable'],
            'payment.other' => ['nullable'],
        ];
    }

    public function mount(Payment $payment)
    {
        $this->last_payment = Payment::where('loan_id', $this->loan->id)->latest('made_date')->first() ?? null;
        if (!$payment->exists) {
            $this->payment = new Payment();
            if ($this->last_payment != null) {
                $this->payment->scheduled_date = $this->last_payment->made_date->addMonth();
                $this->numMonth = $this->last_payment->made_date->diffInMonths(Carbon::now());
                $capitalPagado = $this->loan->payments->sum('principal_amount');
                $pendienteCapital = $this->loan->amount - $capitalPagado;
                $interesMensual = ($pendienteCapital * $this->loan->interest) / 100;
                $this->payment->interest_amount = $interesMensual;
            } else {
                $this->payment->scheduled_date = $this->loan->date_made->addMonth();
                $this->numMonth = $this->loan->date_made->diffInMonths(Carbon::now());
                $this->payment->interest_amount = $this->loan->amount * $this->loan->interest / 100;
            }

            $this->payment->made_date = Carbon::now()->format('Y-m-d');
            $this->payment->other = null;
        } else {
            $this->payment = $payment;
        }

        if ($this->loan->status == 'liquidado') {
            $status = true;
        }
    }

    public function save()
    {
        $this->validate();
        $this->payment->loan_id = $this->loan->id;
        $this->payment->save();
        //Redirigir para imprimir el ticket
        return redirect()->route('loans.show', $this->loan);
    }

    public function render()
    {
        return view('livewire.payments.payment-form', [
            'loan' => $this->loan,
        ]);
    }
}
