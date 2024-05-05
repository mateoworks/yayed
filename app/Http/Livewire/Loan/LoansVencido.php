<?php

namespace App\Http\Livewire\Loan;

use App\Exports\PendientesPagoExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class LoansVencido extends Component
{
    public $prestamosVencidos = [];
    public $noDias;
    private $query;

    public function mount()
    {
        $this->noDias = 35;
        $this->consultarBD();
    }

    public function exportPDF()
    {
        $this->consultarBD();
        $data = [
            'prestamosVencidos' => $this->prestamosVencidos,
            'noDias' => $this->noDias,
        ];
        $pdf = Pdf::loadView('pdf-template.vencidos-prestamo', $data)->setPaper('letter', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-prestamos-vencidos.pdf');
    }

    public function exportExcel()
    {
        $this->consultarBD();
        return Excel::download(
            new PendientesPagoExport($this->query),
            Carbon::now()->format('Y_m_d') . '-prestamos.xlsx'
        );
    }

    public function consultarBD()
    {
        $this->validate(['noDias' => 'required']);
        $this->query = "
        SELECT 
            p.id, 
            (
                SELECT MAX(pg.made_date) 
                FROM payments pg 
                WHERE pg.loan_id = p.id
            ) as ultimo_pago,
            p.id, 
            (
                SELECT SUM(pg.principal_amount) 
                FROM payments pg 
                WHERE pg.loan_id = p.id
            ) as capital_pagado,
            CONCAT(c.names, ' ', c.surname_father, ' ', c.surname_mother) AS full_name,
            c.phone AS phone,
            p.amount,
            c.id AS partner_id,
            p.status,
            c.number
        FROM loans p
        JOIN partners c ON p.partner_id = c.id
        WHERE (
            SELECT DATEDIFF(NOW(), MAX(pg.made_date)) 
            FROM payments pg 
            WHERE pg.loan_id = p.id
        ) > $this->noDias AND p.status != 'liquidado'
        ORDER BY ultimo_pago
        ";
        $this->prestamosVencidos = DB::select($this->query);
    }

    public function render()
    {
        return view('livewire.loan.loans-vencido');
    }
}
