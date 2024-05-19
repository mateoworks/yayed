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
        $this->noDias = 30;
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
            COALESCE(MAX(pg.made_date), p.date_made) AS ultimo_pago,
            SUM(pg.principal_amount) AS capital_pagado,
            CONCAT(c.names, ' ', c.surname_father, ' ', c.surname_mother) AS full_name,
            c.phone AS phone,
            p.amount,
            c.id AS partner_id,
            p.status,
            c.number
        FROM loans p
        JOIN partners c ON p.partner_id = c.id
        LEFT JOIN payments pg ON pg.loan_id = p.id
        WHERE p.status != 'liquidado'
        GROUP BY p.id, c.names, c.surname_father, c.surname_mother, c.phone, p.amount, p.date_made
        HAVING (
            COALESCE(MAX(pg.made_date), p.date_made) < NOW() - INTERVAL $this->noDias DAY
        )
        ORDER BY ultimo_pago
        ";
        $this->prestamosVencidos = DB::select($this->query);
    }

    public function render()
    {
        return view('livewire.loan.loans-vencido');
    }
}
