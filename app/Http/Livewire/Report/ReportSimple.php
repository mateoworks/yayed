<?php

namespace App\Http\Livewire\Report;

use App\Models\Payment;
use Livewire\Component;

class ReportSimple extends Component
{
    public $dateStart;
    public $dateEnd;
    public $pagos = [];
    public function render()
    {
        return view('livewire.report.report-simple');
    }

    public function generar()
    {
        $this->pagos = Payment::whereBetween('made_date', [$this->dateStart, $this->dateEnd])
            ->latest('made_date')
            ->get();
    }
}
