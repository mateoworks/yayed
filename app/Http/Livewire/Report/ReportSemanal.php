<?php

namespace App\Http\Livewire\Report;

use App\Models\Loan;
use App\Models\Solicitud;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportSemanal extends Component
{
    public $dateStart;
    public $dateEnd;
    public $tipoConsulta;
    public $resultados = [];
    public $porSemana = [];
    protected function rules()
    {
        return [
            'dateStart' => ['required', 'date'],
            'dateEnd' => ['required', 'date'],
            'tipoConsulta' => ['nullable'],
        ];
    }
    public function exportPDF()
    {
        $this->generar();

        $data = [
            'dateStart' => Carbon::parse($this->dateStart),
            'dateEnd' => Carbon::parse($this->dateEnd),
            'porSemana' => $this->porSemana,
        ];
        $pdf = Pdf::loadView('pdf-template.reporte-semanal', $data)->setPaper('letter');

        return response()->streamDownload(function () use ($pdf) {
            echo  $pdf->stream();
        }, Carbon::now()->format('Y_m_d') . '-reporte-semanal.pdf');
    }
    public function generar()
    {
        $this->validate();
        $this->resultados = [];
        $tipoConsulta = $this->tipoConsulta;
        $query = "";
        switch ($tipoConsulta) {
            case 'loans':
                $query = "
                    SELECT
                        l.id,
                        WEEK(date_made) AS semana,
                        date_made AS fecha,
                        amount AS monto,
                        CONCAT(p.names, ' ', p.surname_father, ' ', p.surname_mother) AS nombre,
                        'loans' AS tabla
                        FROM loans l
                        LEFT JOIN partners p ON l.partner_id = p.id
                        WHERE date_made BETWEEN '$this->dateStart' AND '$this->dateEnd'
                ";
                break;
            case 'solicitudes':
                $query = "
                    SELECT
                        s.id,
                        WEEK(date_solicitud) AS semana,
                        date_solicitud AS fecha,
                        mount AS monto,
                        CONCAT(p.names, ' ', p.surname_father, ' ', p.surname_mother) AS nombre,
                        'solicituds' AS tabla
                        FROM solicituds s
                        LEFT JOIN partners p ON s.partner_id = p.id
                        WHERE date_solicitud BETWEEN '$this->dateStart' AND '$this->dateEnd'
                ";
                break;
            case 'payments':
                $query = "
                    SELECT
                        pay.id,
                        WEEK(made_date) AS semana,
                        made_date AS fecha,
                        principal_amount + interest_amount AS monto,
                        CONCAT(p.names, ' ', p.surname_father, ' ', p.surname_mother) AS nombre,
                        'payments' AS tabla
                        FROM payments pay
                        LEFT JOIN loans l ON l.id = pay.loan_id
                        LEFT JOIN partners p ON p.id = l.partner_id
                        WHERE made_date BETWEEN '$this->dateStart' AND '$this->dateEnd'
                ";
                break;
            default:
                $query = "
                SELECT
                l.id,
                WEEK(date_made) AS semana,
                date_made AS fecha,
                amount AS monto,
                CONCAT(p.names, ' ', p.surname_father, ' ', p.surname_mother) AS nombre,
                'loans' AS tabla
                FROM loans l
                LEFT JOIN partners p ON l.partner_id = p.id
                WHERE date_made BETWEEN '$this->dateStart' AND '$this->dateEnd'
            UNION
            SELECT
                s.id,
                WEEK(date_solicitud) AS semana,
                date_solicitud AS fecha,
                mount AS monto,
                CONCAT(p.names, ' ', p.surname_father, ' ', p.surname_mother) AS nombre,
                'solicituds' AS tabla
                FROM solicituds s
                LEFT JOIN partners p ON s.partner_id = p.id
                WHERE date_solicitud BETWEEN '$this->dateStart' AND '$this->dateEnd'
            UNION
            SELECT
                pay.id,
                WEEK(made_date) AS semana,
                made_date AS fecha,
                principal_amount + interest_amount AS monto,
                CONCAT(p.names, ' ', p.surname_father, ' ', p.surname_mother) AS nombre,
                'payments' AS tabla
                FROM payments pay
                LEFT JOIN loans l ON l.id = pay.loan_id
                LEFT JOIN partners p ON p.id = l.partner_id
                WHERE made_date BETWEEN '$this->dateStart' AND '$this->dateEnd'
            ORDER BY fecha DESC
                ";
                break;
        }
        $this->resultados = DB::select($query);

        $this->porSemana = [];
        foreach ($this->resultados as $date) {
            $weekNumber = $date->semana;
            $carbonDate = Carbon::parse($date->fecha);
            $weekStartDate = $carbonDate->startOfWeek()->format('d/m/Y');
            $weekEndDate = $carbonDate->endOfWeek()->format('d/m/Y');
            $weekLabel = 'Semana del ' . $weekStartDate . ' al ' . $weekEndDate;
            $this->porSemana[$weekNumber][$weekLabel][] = $date;
        }
    }
    public function render()
    {
        return view('livewire.report.report-semanal');
    }
}
