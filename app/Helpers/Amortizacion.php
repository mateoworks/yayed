<?php

namespace App\Helpers;

use App\Models\Loan;

class Amortizacion
{
    public Loan $loan;

    public $amortizacion = [];
    public $sumInteres = 0;
    public $sumAmortizacion = 0;
    public $pagoMensual = 0;
    public $periodos = 0;
    public function __construct($loan)
    {
        $this->loan = $loan;
        $this->generarAmortizacion();
    }

    public function generarAmortizacion()
    {
        $interes = $this->interes();
        $capital = $this->loan->amount;
        $pagoFormula = $this->pago($capital, $this->periodos(), $interes);
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
        } while ($i <= $this->periodos());

        $this->sumInteres = $sumInt;
        $this->sumAmortizacion = $sumAmor;

        return $this->amortizacion;
    }

    public function sumInteres()
    {
        return $this->sumInteres();
    }

    public function sumAmortizacion()
    {
        return $this->sumAmortizacion;
    }

    public function getPago()
    {
        return $this->pagoMensual;
    }

    protected function interes()
    {
        return $this->loan->interest / 100;
    }

    public function periodos()
    {
        $noPeriodos = $this->loan->date_made->floatDiffInMonths($this->loan->date_payment);
        $this->periodos = round($noPeriodos, 0);
        return $this->periodos;
    }

    public function pago($capital, int $periodos, $interes)
    {
        $this->pagoMensual = ($capital * $interes) / (1 - pow(1 + $interes, -$periodos));
        return $this->pagoMensual;
    }
}
