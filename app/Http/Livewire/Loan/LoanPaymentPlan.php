<?php

namespace App\Http\Livewire\Loan;

use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class LoanPaymentPlan extends Component
{
    public Loan $loan;
    public $cantidadCapitalMes;
    public array $plan = [];
    public function mount()
    {
        $this->cantidadCapitalMes = 0;
    }
    public function rules()
    {
        return ['cantidadCapitalMes' => ['required', 'numeric', 'min:100', 'max:' . $this->loan->amount]];
    }
    public function generar()
    {
        $this->validate();
        $this->plan = array();
        $capital = $this->loan->amount;
        $mes = $this->loan->date_made;
        $pagoCap = 0;
        do {
            $plan1 = new Plan();
            $plan1->capital = $capital;
            $plan1->interes = $capital * $this->loan->interest / 100;
            $plan1->pagoCapital = $capital > $this->cantidadCapitalMes ? $this->cantidadCapitalMes : $this->loan->amount - $pagoCap;
            $pagoCap += $plan1->pagoCapital;
            $plan1->mes = $mes;
            $capital -= $this->cantidadCapitalMes;
            //$mes = $mes->addMonth();
            $this->plan[] = $plan1;
        } while ($capital > 0);
    }
    public function render()
    {
        return view('livewire.loan.loan-payment-plan', [
            'loan' => $this->loan
        ]);
    }

    public function createPDF()
    {
        $this->generar();
        //Recuperar todos los productos de la db
        $data = [
            'loan' => $this->loan,
            'plan' => $this->plan,
        ];
        $pdf = Pdf::loadView('other.plan', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, 'contrato_' . $this->loan->number . '.pdf');
    }
}
class Plan
{
    public $capital;
    public $interes;
    public $pagoCapital;
    public Carbon $mes;
}
