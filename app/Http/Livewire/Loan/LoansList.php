<?php

namespace App\Http\Livewire\Loan;

use App\Exports\LoansExport;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class LoansList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $status = '';
    public function render()
    {
        $searched = $this->search;
        return view('livewire.loan.loans-list', [
            'loans' => Loan::where('status', 'like', "%$this->status%")
                ->with('partner')
                ->whereHas('partner', function ($q) use ($searched) {
                    $q->where(DB::raw("CONCAT(names, ' ', surname_father, ' ', surname_mother)"), 'like', "%$searched%");
                })
                ->latest('date_made')
                ->paginate(),
        ]);
    }

    public function destroyLoan(Loan $loan)
    {
        $loan->delete();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó el préstamo']);
    }
    public function exportExcel()
    {
        return Excel::download(
            new LoansExport(),
            Carbon::now()->format('Y_m_d') . '-prestamos.xlsx'
        );
    }
}
