<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Loan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LoansExport implements FromCollection, WithColumnFormatting, WithMapping, WithHeadings
{
    public function collection()
    {
        return Loan::all();
    }
    public function map($loan): array
    {
        return [
            $loan->number,
            $loan->partner->full_name,
            $loan->partner->phone,
            $loan->amount,
            $loan->amount_letter,
            $loan->interest,
            Date::dateTimeToExcel($loan->date_made),
            Date::dateTimeToExcel($loan->date_payment),
            $loan->payments->count(),
            $loan->payments->sum('principal_amount'),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }

    public function headings(): array
    {
        return [
            'Numero identificador',
            'Socio',
            'Teléfono del socio',
            'Cantidad prestada',
            'Cantidad en letra',
            'Interés %',
            'Fecha realizada',
            'Fecha programada de pago',
            'Pagos realizados',
            'Cantidad capital pagado'
        ];
    }
}
