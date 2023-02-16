<?php

namespace App\Http\Livewire\Report;

use App\Exports\TablesExport;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class ExportTable extends Component
{
    public $porPeriodoSelect = false;
    public $periodo;

    public $dateStart;
    public $dateEnd;

    public $table = [];

    public $tableExport = [];

    public function mount()
    {
        $this->table = [
            'PartnersExport' => true,
        ];
    }

    public function exportar()
    {
        foreach ($this->table as $key => $value) {
            array_push($this->tableExport, $key);
        }
        $localExport = $this->tableExport;
        $this->limpiarArry();
        return Excel::download(
            new TablesExport($localExport, $this->dateStart, $this->dateEnd),
            Carbon::now()->format('Y_m_d') . '-tablas-Yayed.xlsx'
        );
    }

    public function limpiarArry()
    {
        $this->table = array();
        $this->tableExport = array();
        $this->dateStart = null;
        $this->dateEnd = null;
        $this->periodo = null;
    }

    public function porPeriodo()
    {
        if ($this->periodo == 'personalizado') {
            $this->porPeriodoSelect = true;
        } else if ($this->periodo != 'personalizado') {
            $this->porPeriodoSelect = false;
        }
    }
    public function render()
    {
        return view('livewire.report.export-table');
    }
}
