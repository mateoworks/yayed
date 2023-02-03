<?php

namespace App\Http\Livewire\Loan;

use App\Models\Loan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

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
        foreach ($loan->warranties as $warranty) {
            if ($warranty->url_document) {
                if (Storage::disk('public')->exists($warranty->url_document)) {
                    Storage::disk('public')->delete($warranty->url_document);
                }
            }
        }
        $loan->delete();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó el préstamo']);
    }
}
