<?php

namespace App\Exports;

use App\Models\Partner;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PartnersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithTitle
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
        return Partner::all();
    }

    public function map($partner): array
    {
        return [
            $partner->number,
            $partner->names,
            $partner->surname_father,
            $partner->surname_mother,
            $partner->phone,
            $partner->gender,
            $partner->birthday ? Date::dateTimeToExcel($partner->birthday) : '',
            $partner->birthday ? $partner->age : '',
            $partner->job,
            $partner->address,
            $partner->address_number,
            $partner->barrio,
            $partner->cp,
            $partner->suburb,
            $partner->municipio,
            $partner->estado,
            $partner->civil_status,
            $partner->curp,
            $partner->key_ine,
            $partner->email,
            $partner->dwelling,
            $partner->dependents,
            $partner->id,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function headings(): array
    {
        return [
            'Folio',
            'Nombre',
            'Primer apellido',
            'Segundo apellido',
            'Teléfono',
            'Género',
            'Fecha de nacimiento',
            'Edad',
            'Ocupación',
            'Calle',
            'Número',
            'Barrio',
            'Código postal',
            'Colonia',
            'Municipio',
            'Estado',
            'Estado civil',
            'CURP',
            'Clave INE',
            'Correo electrónico',
            'Vivienda',
            'Dependientes',
            'Id en el sistema',
        ];
    }

    public function title(): string
    {
        return 'Socios';
    }
}
