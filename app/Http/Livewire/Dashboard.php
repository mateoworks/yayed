<?php

namespace App\Http\Livewire;

use App\Models\Loan;
use App\Models\Partner;
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
    public $capitalRecuperado;

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
        $this->dataJson = json_encode($this->data ?? []);
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

    public function cantidadEnPrestamo()
    {
        $prestamosActivos = Loan::where('status', 'activo')->get();
        $prestado = 0;
        $pagado = 0;
        foreach ($prestamosActivos as $loan) {
            $prestado += $loan->amount;
            $pagado += $loan->payments->sum('principal_amount');
        }
        $this->capitalRecuperado = $pagado;
        return $prestado - $pagado;
    }
    public function render()
    {
        $pendientesPago = DB::select("
        SELECT
            p.id,
            COALESCE(MAX(pg.made_date), p.date_made) AS ultimo_pago,
            SUM(pg.principal_amount) AS capital_pagado,
            CONCAT(c.names, ' ', c.surname_father, ' ', c.surname_mother) AS full_name,
            c.phone AS phone,
            p.amount
        FROM loans p
        JOIN partners c ON p.partner_id = c.id
        LEFT JOIN payments pg ON pg.loan_id = p.id
        WHERE p.status != 'liquidado'
        GROUP BY p.id, c.names, c.surname_father, c.surname_mother, c.phone, p.amount, p.date_made
        HAVING (
            COALESCE(MAX(pg.made_date), p.date_made) < NOW() - INTERVAL 30 DAY
        )
        ORDER BY ultimo_pago DESC
        LIMIT 20;
        ");

        $cantidadAtrazados = 0;

        foreach ($pendientesPago as $prestamo) {
            $cantidadAtrazados++;
        }
        return view('livewire.dashboard', [
            'loans' => Loan::where('status', 'activo')->latest()->take(5)->get(),
            'pagosPendintes' => $pendientesPago,
            'no_partners' => Partner::count(),
            'no_prestamos' => Loan::where('status', 'activo')->count(),
            'en_prestamo' => $this->cantidadEnPrestamo(),
            'capital_recuperado' => $this->capitalRecuperado,
            'cantidad_prestamo' => Loan::where('status', 'activo')->sum('amount'),
            'cantidadAtrazados' => $cantidadAtrazados,
        ]);
    }
}
