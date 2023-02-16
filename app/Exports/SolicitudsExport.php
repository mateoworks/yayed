<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Solicitud;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SolicitudsExport implements WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithTitle, FromQuery
{
    public $inicio;
    public $fin;
    public function __construct($inicio = null, $fin = null)
    {
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function query()
    {
        if ($this->inicio != null && $this->fin != null) {
            return Solicitud::query()->whereBetween('date_solicitud', [$this->inicio, $this->fin]);
        }
        return Solicitud::query();
    }

    public function map($solicitud): array
    {
        return [
            $solicitud->folio,
            $solicitud->partner->full_name,
            $solicitud->partner->number,
            Date::dateTimeToExcel($solicitud->date_solicitud),
            Date::dateTimeToExcel($solicitud->date_payment),
            $solicitud->date->date_aproved ?? '',
            $solicitud->period,
            $solicitud->mount,
            $solicitud->concept,
            $solicitud->condition,
            $solicitud->loan->number ?? '',
            $solicitud->id,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }

    public function headings(): array
    {
        return [
            'Folio solicitud',
            'Socio',
            'Folio socio',
            'Fecha de la solicitud',
            'Fecha de pago',
            'Fecha de aprobación',
            'Periodos',
            'Monto solicitado',
            'Concepto',
            'Situación',
            'Folio de préstamo',
            'ID en el sistema',
        ];
    }

    public function title(): string
    {
        return 'Solicitudes';
    }
}
