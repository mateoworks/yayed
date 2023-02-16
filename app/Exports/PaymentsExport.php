<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PaymentsExport implements FromQuery, WithMapping, WithColumnFormatting, WithHeadings, ShouldAutoSize, WithTitle
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
            return Payment::query()->whereBetween('made_date', [$this->inicio, $this->fin])->orderBy('number', 'DESC');
        }
        return Payment::query()->orderBy('number', 'DESC');
    }

    public function map($payment): array
    {
        return [
            $payment->number,
            $payment->loan->number,
            $payment->loan->partner->number,
            $payment->loan->partner->full_name,
            $payment->type,
            $payment->period,
            Date::dateTimeToExcel($payment->scheduled_date),
            Date::dateTimeToExcel($payment->made_date),
            $payment->principal_amount,
            $payment->interest_amount,
            $payment->other,
            $payment->other_amount,
            $payment->social_contribution,
            $payment->concept,
            $payment->observations,
            $payment->user->name . ' ' . $payment->user->surname,
            $payment->id,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'J' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'L' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'M' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
        ];
    }

    public function headings(): array
    {
        return [
            'Folio pago',
            'Folio préstamo',
            'Folio socio',
            'Socio',
            'Tipo pago',
            'Periodo',
            'Fecha programada',
            'Fecha realizada',
            'Pago de capital',
            'Pago de interés',
            'Otro concepto',
            'Pago de otros',
            'Retiro de aportación social',
            'Concepto de pago',
            'Observaciones',
            'Cajero(a)',
            'ID en el sistema'
        ];
    }

    public function title(): string
    {
        return 'Pagos';
    }
}
