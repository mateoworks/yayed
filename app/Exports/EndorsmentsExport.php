<?php

namespace App\Exports;

use App\Models\Endorsement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class EndorsmentsExport implements FromCollection, WithMapping, WithHeadings, WithTitle, ShouldAutoSize
{
    public $inicio;
    public $fin;
    public function __construct($inicio = null, $fin = null)
    {
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function collection()
    {
        return Endorsement::all();
    }

    public function map($endorsement): array
    {
        return [
            $endorsement->full_name,
            $endorsement->phone,
            $endorsement->address,
            $endorsement->id,
        ];
    }

    public function headings(): array
    {
        return [
            'Nombre del aval',
            'Teléfono',
            'Dirección',
            'ID en el sistema',
        ];
    }

    public function title(): string
    {
        return 'Avales';
    }
}
