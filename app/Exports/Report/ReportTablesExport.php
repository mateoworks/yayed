<?php

namespace App\Exports\Report;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportTablesExport implements FromCollection, WithMapping, WithColumnFormatting, WithHeadings, WithTitle, ShouldAutoSize
{
    protected $data;
    protected $nameSheet;
    public $months = [1 => 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

    public function __construct($data, $nameSheet)
    {
        $this->data = $data;
        $this->nameSheet = $nameSheet;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function map($data): array
    {
        return [
            ($data->mes != null ? ucfirst($this->months[$data->mes]) : '') . ' ' . $data->anio,
            $data->monto
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' =>  NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }

    public function headings(): array
    {
        return [
            'Mes',
            'Monto',
        ];
    }

    public function title(): string
    {
        return $this->nameSheet;
    }
}
