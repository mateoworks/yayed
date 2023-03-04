<?php

namespace App\Http\Livewire\Report;

use App\Exports\Report\CapitalReportExport;
use App\Exports\Report\InterestReportExport;
use App\Exports\Report\LoansReportExport;
use App\Exports\Report\ReportMonth;
use App\Models\Contribution;
use App\Models\Loan;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ReportSimple extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $dateStart;
    public $dateEnd;
    public $months = [1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    public $payments = [];
    public $loans = [];
    public $interesPorMes = [];
    public $capitalPorMes = [];
    public $prestamosPorMes = [];
    public $aportacionPorMes = [];

    public $anexos;

    protected function rules()
    {
        return [
            'dateStart' => ['required', 'date'],
            'dateEnd' => ['required', 'date'],
        ];
    }

    public function render()
    {
        return view('livewire.report.report-simple', [
            'pagosPrueba' => Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
                ->latest('made_date')
                ->paginate(),
            'prestamos' => Loan::whereBetween('date_made', [$this->dateStart, $this->dateEnd])
                ->latest('date_made')
                ->paginate(),
        ]);
    }

    public function exportPDF()
    {
        $this->generar();
        $data = [
            'months' => $this->months,
            'dateStart' => Carbon::parse($this->dateStart),
            'dateEnd' => Carbon::parse($this->dateEnd),
            'prestamosPorMes' => $this->prestamosPorMes,
            'interesPorMes' => $this->interesPorMes,
            'aportacionPorMes' => $this->aportacionPorMes,
            'capitalPorMes' => $this->capitalPorMes
        ];
        $tables = [];
        if ($this->anexos) {
            $tables = [
                'payments' => $this->payments,
                'loans' => $this->loans,
            ];
        }
        $data = array_merge($data, $tables);
        $pdf = Pdf::loadView('pdf-template.reporte-mensual', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-reporte-mensual.pdf');
    }

    public function exportExcel()
    {
        $this->generar();
        $inicio = null;
        $fin = null;
        if ($this->anexos) {
            $inicio = $this->dateStart;
            $fin = $this->dateEnd;
        }
        return Excel::download(
            new ReportMonth(
                $this->prestamosPorMes,
                $this->interesPorMes,
                $this->capitalPorMes,
                $this->aportacionPorMes,
                $inicio,
                $fin
            ),
            Carbon::now()->format('Y_m_d') . '-reporte.xlsx'
        );
    }

    public function generar()
    {
        $this->validate();

        $this->interesPorMes = array();
        $this->capitalPorMes = array();
        $this->prestamosPorMes = array();
        $this->aportacionPorMes = array();

        $this->payments = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->latest('made_date')
            ->get();
        $this->loans = Loan::whereBetween('date_made', [$this->dateStart, $this->dateEnd])
            ->latest('date_made')
            ->get();

        $this->interesPorMes = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(made_date) AS mes, YEAR(made_date) AS anio, SUM(interest_amount) as monto")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();

        $this->capitalPorMes = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(made_date) AS mes, YEAR(made_date) AS anio, SUM(principal_amount) as monto")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();

        $this->prestamosPorMes = Loan::whereBetween('date_made', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(date_made) AS mes, YEAR(date_made) AS anio, SUM(amount) as monto")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();

        $this->aportacionPorMes = Contribution::whereBetween('date_made', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(date_made) AS mes, YEAR(date_made) AS anio, SUM(amount) as monto")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();
    }
}
