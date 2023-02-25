<?php

namespace App\Http\Livewire\Payments;

use Illuminate\Support\Arr;
use App\Helpers\Amortizacion;
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
    public $status = 0;
    public $pendienteCap;
    public $diasPendientes;

    public $interest;

    public $amortizacion = [];
    protected function rules()
    {
        return [
            'payment.scheduled_date' => ['required', 'date'],
            'payment.made_date' => ['required', 'date'],
            'payment.type' => ['nullable'],
            'payment.social_contribution' => ['nullable', 'numeric', 'max:' . $this->loan->partner->social_contribution],
            'payment.period' => ['nullable'],
            'payment.concept' => ['nullable'],
            'payment.interest_amount' => ['nullable', 'numeric'],
            'payment.principal_amount' => ['nullable', 'numeric'],
            'payment.other_amount' => ['nullable', 'numeric'],
            'payment.observations' => ['nullable'],
            'payment.other' => ['nullable']
        ];
    }

    public function mount(Payment $payment)
    {

        $this->last_payment = Payment::where('loan_id', $this->loan->id)->latest('made_date')->first() ?? null;

        if (!$payment->exists) {
            $this->payment = new Payment();
            if ($this->last_payment != null) {
                $this->diasPendientes = Carbon::now()->diffInDays($this->last_payment->made_date);

                if ($this->diasPendientes > 90) {
                    $this->loan->interest = 3;
                }

                $this->payment->scheduled_date = $this->last_payment->made_date->addMonth();
                $this->numMonth = $this->last_payment->made_date->diffInMonths(Carbon::now());
                $capitalPagado = $this->loan->payments->sum('principal_amount');
                $pendienteCapital = $this->loan->amount - $capitalPagado;
                $interesMensual = ($pendienteCapital * $this->loan->interest) / 100;
                $this->payment->interest_amount = $interesMensual;
                $this->pendienteCap = $pendienteCapital;

                $this->payment->period = $this->loan->payments->count() + 1;
            } else {
                $this->diasPendientes = Carbon::now()->diffInDays($this->loan->date_made);

                if ($this->diasPendientes > 90) {
                    $this->loan->interest = 3;
                }

                $this->payment->scheduled_date = $this->loan->date_made->addMonth();
                $this->numMonth = $this->loan->date_made->diffInMonths(Carbon::now());
                $this->payment->interest_amount = $this->loan->amount * $this->loan->interest / 100;
                $this->payment->period = 1;
                $this->pendienteCap = $this->loan->amount;
            }

            $this->payment->made_date = $this->payment->scheduled_date;
            $this->payment->other = null;
        } else {
            $this->payment = $payment;
        }

        if ($this->loan->status == 'liquidado') {
            $status = 1;
        }

        $amor = new Amortizacion($this->loan);
        $this->amortizacion = $amor->amortizacion;
        $this->interest = $this->loan->interest;
        $this->pagoCapital();
    }

    public function activar()
    {
        if ($this->payment->principal_amount >= $this->pendienteCap) {
            $this->status = 1;
        }
    }

    public function save()
    {

        $this->validate();

        $this->payment->loan_id = $this->loan->id;
        $this->payment->user_id = auth()->user()->id;
        $this->payment->save();

        if ($this->payment->social_contribution > 0) {
            $partner = $this->loan->partner;
            $partner->social_contribution -= $this->payment->social_contribution;
            $partner->save();
        }
        //Redirigir para imprimir el ticket
        return redirect()->route('payments.show', $this->payment);
    }

    public function pagoCapital()
    {
        if (array_key_exists($this->payment->period - 1, $this->amortizacion)) {
            $capitalAmortizacion = $this->amortizacion[$this->payment->period - 1];
            $capital = round($capitalAmortizacion->amortizacion, 2);
        } else {
            $capital = 0;
        }
        $this->payment->principal_amount = $capital;
    }

    public function updatedInterest()
    {
        $this->loan->interest = $this->interest;
        $this->payment->interest_amount = $this->loan->amount * $this->loan->interest / 100;
        $amor = new Amortizacion($this->loan);
        $this->amortizacion = $amor->amortizacion;
        $this->pagoCapital();
    }

    public function render()
    {
        $amor = new Amortizacion($this->loan);
        $this->amortizacion = $amor->amortizacion;
        return view('livewire.payments.payment-form', [
            'loan' => $this->loan,
        ]);
    }
}
