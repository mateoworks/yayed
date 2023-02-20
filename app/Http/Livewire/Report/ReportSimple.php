<?php

namespace App\Http\Livewire\Report;

use App\Models\Contribution;
use App\Models\Loan;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportSimple extends Component
{
    public $dateStart;
    public $dateEnd;
    public $months = [1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    public $pagos = [];
    public $interesPorMes = [];
    public $capitalPorMes = [];
    public $prestamosPorMes = [];
    public $aportacionPorMes = [];

    protected function rules()
    {
        return [
            'dateStart' => ['required', 'date'],
            'dateEnd' => ['required', 'date'],
        ];
    }

    public function render()
    {
        return view('livewire.report.report-simple');
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
        $pdf = Pdf::loadView('pdf-template.reporte-mensual', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-reporte-mensual.pdf');
    }

    public function generar()
    {
        $this->validate();

        $this->pagos = array();
        $this->interesPorMes = array();
        $this->capitalPorMes = array();
        $this->prestamosPorMes = array();
        $this->aportacionPorMes = array();

        $this->pagos = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->latest('made_date')
            ->get();

        $this->interesPorMes = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(made_date) AS mes, YEAR(made_date) AS anio, SUM(interest_amount) as interes")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();

        $this->capitalPorMes = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(made_date) AS mes, YEAR(made_date) AS anio, SUM(principal_amount) as capital")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();

        $this->prestamosPorMes = Loan::whereBetween('date_made', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(date_made) AS mes, YEAR(date_made) AS anio, SUM(amount) as capital")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();

        $this->aportacionPorMes = Contribution::whereBetween('date_made', [$this->dateStart, $this->dateEnd])
            ->selectRaw("MONTH(date_made) AS mes, YEAR(date_made) AS anio, SUM(amount) as aportacion")
            ->groupBy(DB::raw("mes, anio"))
            ->orderByRaw("anio, mes")
            ->get();
    }
}
