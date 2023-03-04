<?php

namespace App\Http\Livewire\Partner;

use App\Exports\PartnersExport;
use App\Models\Config;
use App\Models\Partner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class PartnersList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function render()
    {
        $solicitud = Config::where('key', 'solicitud')->first();
        return view('livewire.partner.partners-list', [
            'partners' => Partner::where('names', 'like', "%$this->search%")
                ->orWhere('surname_father', 'like', "%$this->search%")
                ->orWhere('surname_mother', 'like', "%$this->search%")
                ->orWhere('curp', 'like', "%$this->search%")
                ->latest()
                ->paginate(),
            'solicitudActive' => $solicitud->value ?? null,
        ]);
    }

    public function exportExcel()
    {
        return Excel::download(
            new PartnersExport(),
            Carbon::now()->format('Y_m_d') . '-socios.xlsx'
        );
    }

    public function destroy(Partner $partner)
    {
        if ($partner->image) {
            if (Storage::disk('public')->exists($partner->image)) {
                Storage::disk('public')->delete($partner->image);
            }
        }
        if ($partner->documents->isNotEmpty()) {
            foreach ($partner->documents as $document) {
                if ($document->url) {
                    if (Storage::disk('public')->exists($document->url)) {
                        Storage::disk('public')->delete($document->url);
                    }
                }
            }
        }
        $partner->delete();
        $this->dispatchBrowserEvent('message', [
            'message' => 'Se eliminó correctamente este socio',
            'backgroundColor' => '00ab55'
        ]);
    }
}
