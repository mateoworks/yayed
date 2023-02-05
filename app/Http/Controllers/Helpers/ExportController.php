<?php

namespace App\Http\Controllers\Helpers;

use App\Exports\AmortizacionExport;
use App\Exports\LoansExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function loansExportExcel()
    {
        return Excel::download(new LoansExport, 'prestamos.xlsx');
    }
    public function amortizacionExportExcel($amortizacion)
    {
        return Excel::download(new AmortizacionExport($amortizacion), 'Amortizacion.xlsx');
    }
}
