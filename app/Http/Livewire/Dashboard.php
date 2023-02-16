<?php

namespace App\Http\Livewire;

use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $cantidad;
    public $statusPrestamos;

    public $tiempo = 'year';
    public array $data;
    public $dataJson;
    public $months = [1 => 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];

    public $totalInteres;

    public $periodoInteres;

    public function mount()
    {
        $this->periodoInteres = $this->periodoInteres = Carbon::now()->subYear()->format('Y-m-d');
        $this->generarDatosInteres();

        $status = DB::select("
        SELECT status AS estado, sum(amount) AS monto from loans GROUP BY estado
        ");
        $estado = array();
        foreach ($status as $item) {
            $estado['status'][] = $item->estado;
            $estado['monto'][] = $item->monto;
        }
        $this->statusPrestamos = $estado;
        $this->dataJson = json_encode($this->data);
    }

    public function generarDatosInteres()
    {
        $this->cantidad = DB::select("
        SELECT MONTH(made_date) AS mes, YEAR(made_date) AS anio, sum(interest_amount) AS monto FROM payments 
        WHERE made_date >= '{$this->periodoInteres}'
        GROUP BY mes, anio
        ORDER BY anio, mes");

        $sumatorio = 0;

        foreach ($this->cantidad as $item) {
            $sumatorio += $item->monto;
            $this->data['value'][] = $sumatorio;
            $this->data['lavel'][] = ucfirst($this->months[$item->mes])  . ' ' . $item->anio;
            $this->data['porMes'][] = $item->monto;
        }
        $this->totalInteres = $sumatorio;
    }
    public function porPeriodo($periodo)
    {
        if ($periodo == 'anual') {
            $this->periodoInteres = Carbon::now()->subYear()->format('Y-m-d');
        } else if ($periodo == 'semestral') {
            $this->periodoInteres = Carbon::now()->subMonth(6)->format('Y-m-d');
        } else if ($periodo == 'trimestral') {
            $this->periodoInteres = Carbon::now()->subMonth(3)->format('Y-m-d');
        }

        $this->cantidad = DB::select("
        SELECT MONTH(made_date) AS mes, YEAR(made_date) AS anio, sum(interest_amount) AS monto FROM payments 
        WHERE made_date >= '$this->periodoInteres'
        GROUP BY mes, anio
        ORDER BY anio, mes");

        $sumatorio = 0;

        foreach ($this->cantidad as $item) {
            $sumatorio += $item->monto;
            $this->data['value'][] = $sumatorio;
            $this->data['lavel'][] = ucfirst($this->months[$item->mes])  . ' ' . $item->anio;
            $this->data['porMes'][] = $item->monto;
        }
        $this->totalInteres = $sumatorio;
    }
    public function render()
    {
        $pendientesPago = DB::select("
        SELECT
        l.id,
        CONCAT(par.names, ' ', par.surname_father, ' ', par.surname_mother) AS fullname,
        par.phone AS phone,
        l.amount,
        SUM(p.principal_amount) as capital_pagado,
        l.status,
        max(p.scheduled_date) ultimo_pago
        FROM loans l
        LEFT JOIN payments p ON p.loan_id = l.id
        LEFT JOIN partners par ON par.id = l.partner_id
        WHERE l.status = 'activo' AND DATEDIFF(CURDATE(), p.scheduled_date)  > 35
        GROUP BY l.id
        ORDER BY ultimo_pago
        ");
        return view('livewire.dashboard', [
            'loans' => Loan::where('status', 'activo')->latest()->take(5)->get(),
            'pagosPendintes' => $pendientesPago,
        ]);
    }
}
