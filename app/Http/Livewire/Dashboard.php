<?php

namespace App\Http\Livewire;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $cantidad;
    public $statusPrestamos;

    public $tiempo = 'year';
    public array $data;
    public $dataJson;
    public function mount()
    {
        $this->cantidad = DB::select("
        SELECT MONTH(date_made) AS mes, YEAR(date_made) AS anio, sum(amount) AS monto FROM loans 
        WHERE date_made >= '2021-03-03' 
        GROUP BY mes, anio
        ORDER BY anio, mes");
        foreach ($this->cantidad as $item) {
            $this->data['value'][] = $item->monto;
            $this->data['lavel'][] = $item->mes . ' ' . $item->anio;
        }
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
