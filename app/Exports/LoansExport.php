<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class LoansExport implements FromQuery, WithColumnFormatting, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
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
            return Loan::query()->whereBetween('date_made', [$this->inicio, $this->fin])->orderBy('date_made', 'DESC');
        }
        return Loan::query()->orderBy('date_made', 'DESC');
    }

    public function map($loan): array
    {
        return [
            $loan->number,
            $loan->solicitud->folio,
            $loan->partner->full_name,
            $loan->partner->phone,
            $loan->amount,
            $loan->amount_letter,
            $loan->interest,
            Date::dateTimeToExcel($loan->date_made),
            Date::dateTimeToExcel($loan->date_payment),
            $loan->payments->count(),
            $loan->payments->sum('principal_amount'),
            $loan->payments->sum('interest_amount'),
            $loan->id,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'L' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }

    public function headings(): array
    {
        return [
            'Numero identificador',
            'Folio de solicitud',
            'Socio',
            'Teléfono del socio',
            'Cantidad prestada',
            'Cantidad en letra',
            'Interés %',
            'Fecha realizada',
            'Fecha programada de pago',
            'Pagos realizados',
            'Cantidad capital pagado',
            'Cantidad interés pagado',
            'ID en el sistema'
        ];
    }

    public function title(): string
    {
        return 'Préstamos';
    }
}
