<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class AmortizacionExport implements
    FromCollection,
    WithMapping,
    WithHeadings,
    WithColumnFormatting,
    ShouldAutoSize,
    WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        return collect($this->data);
    }

    public function map($data): array
    {
        return [
            $data->np,
            Date::dateTimeToExcel($data->fecha->addMonth()),
            $data->saldoInicial,
            $data->interes,
            $data->amortizacion,
            $data->saldoPagar,
            $data->saldoFinal,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'D' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'F' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'G' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }

    public function headings(): array
    {
        return [
            'Periodos',
            'Fecha',
            'Saldo inicial',
            'Interés',
            'Amortización',
            'Saldo a pagar',
            'Saldo final',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
