<?php

namespace App\Http\Livewire\Loan;

use App\Exports\AmortizacionExport;
use App\Models\Loan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class LoanAmortizacion extends Component
{
    public Loan $loan;
    public $periodos;
    public $amortizacion = [];
    public $sumInteres = 0;
    public $sumAmortizacion = 0;
    public function mount()
    {
        $noPeriodos = $this->loan->date_made->floatDiffInMonths($this->loan->date_payment);
        $this->periodos = round($noPeriodos, 0);
    }
    public function render()
    {
        return view('livewire.loan.loan-amortizacion', [
            'loan' => $this->loan,
        ]);
    }
    public function rules()
    {
        return ['periodos' => ['required', 'numeric', 'min:1', 'max:30']];
    }
    public function generar()
    {
        $this->validate();
        $this->amortizacion = array();
        $interes = $this->loan->interest / 100;
        $capital = $this->loan->amount;
        $pagoFormula = $this->pago($capital, $this->periodos, $interes);
        $mes = $this->loan->date_made;
        $i = 1;
        $sumInt = 0;
        $sumAmor = 0;
        do {
            $pago = new Pago();
            $pago->np = $i;
            $pago->fecha = $mes;
            $pago->saldoPagar = $pagoFormula;
            $pago->saldoInicial = $capital;
            $pago->interes = $pago->saldoInicial * $interes;
            $pago->amortizacion = $pago->saldoPagar - $pago->interes;
            $pago->saldoFinal = $pago->saldoInicial - $pago->amortizacion;
            $capital = $pago->saldoFinal;
            $this->amortizacion[] = $pago;
            $i++;
            $sumInt += $pago->interes;
            $sumAmor += $pago->amortizacion;
        } while ($i <= $this->periodos);
        $this->sumInteres = $sumInt;
        $this->sumAmortizacion = $sumAmor;
    }
    public function pago($capital, int $periodos, $interes)
    {
        return ($capital * $interes) / (1 - pow(1 + $interes, -$periodos));
    }

    public function exportExcel()
    {
        $this->generar();
        return Excel::download(
            new AmortizacionExport($this->amortizacion),
            'mmortizacion_' . $this->loan->number . '.xlsx'
        );
    }

    public function exportPDF()
    {
        $this->generar();
        //Recuperar todos los productos de la db
        $data = [
            'loan' => $this->loan,
            'amortizacion' => $this->amortizacion,
            'sumInteres' => $this->sumInteres,
            'sumAmortizacion' => $this->sumAmortizacion,
        ];
        $pdf = Pdf::loadView('pdf-template.amortizacion-prestamo', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, 'amortizacion_' . $this->loan->number . '.pdf');
    }
}
class Pago
{
    public $np;
    public $fecha;
    public $saldoInicial;
    public $interes;
    public $amortizacion;
    public $saldoPagar;
    public $saldoFinal;
}
