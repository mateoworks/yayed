<?php

namespace App\Exports\Report;

use App\Exports\LoansExport;
use App\Exports\PaymentsExport;
use App\Models\Loan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportMonth implements WithMultipleSheets
{
    use Exportable;
    public $loans;
    public $interesPorMes;
    public $capitalPorMes;
    public $aportacionPorMes;
    public $inicio;
    public $fin;
    public function __construct($loans, $interesPorMes, $capitalPorMes, $aportacionPorMes, $inicio = null, $fin = null)
    {
        $this->loans = $loans;
        $this->interesPorMes = $interesPorMes;
        $this->capitalPorMes = $capitalPorMes;
        $this->aportacionPorMes = $aportacionPorMes;
        $this->inicio = $inicio;
        $this->fin = $fin;
    }
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new ReportTablesExport($this->loans, 'Préstamos realizados');
        $sheets[] = new ReportTablesExport($this->interesPorMes, 'Interés');
        $sheets[] = new ReportTablesExport($this->aportacionPorMes, 'Aportación social');
        $sheets[] = new ReportTablesExport($this->capitalPorMes, 'Capital recuperado');
        if ($this->inicio != null && $this->fin != null) {
            $sheets[] = new LoansExport($this->inicio, $this->fin);
            $sheets[] = new PaymentsExport($this->inicio, $this->fin);
        }
        return $sheets;
    }
}
