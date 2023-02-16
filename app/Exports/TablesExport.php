<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TablesExport implements WithMultipleSheets
{
    use Exportable;

    public $tables = [];
    public $inicio;
    public $fin;

    public function __construct($tables, $inicio = null, $fin = null)
    {
        $this->tables = $tables;
        $this->inicio = $inicio;
        $this->fin = $fin;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->tables as $key => $value) {
            $instancia = trim("App\Exports\ ") . $value;
            $sheets[] = new $instancia($this->inicio, $this->fin);
        }

        return $sheets;
    }
}
