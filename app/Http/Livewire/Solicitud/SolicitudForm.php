<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\Partner;
use App\Models\Solicitud;
use Carbon\Carbon;
use Livewire\Component;

class SolicitudForm extends Component
{
    public Partner $partner;
    public Solicitud $solicitud;
    protected function rules()
    {
        return [
            'solicitud.date_solicitud' => ['required', 'date'],
            'solicitud.date_payment' => ['required', 'date'],
            'solicitud.period' => ['required'],
            'solicitud.mount' => ['required', 'numeric'],
            'solicitud.concept' => ['nullable'],
        ];
    }

    public function mount(Solicitud $solicitud)
    {
        $this->solicitud = $solicitud;
        $this->solicitud->date_solicitud = Carbon::now();
    }

    public function updateDate()
    {
        $this->solicitud->date_payment = $this->solicitud->date_solicitud->addMonths($this->solicitud->period);
    }

    public function save()
    {
        $this->validate();
        $this->solicitud->partner_id = $this->partner->id;
        $this->solicitud->save();
        return redirect()->route('partners.solicitud.show', $this->solicitud);
    }

    public function render()
    {
        return view('livewire.solicitud.solicitud-form', [
            'partner' => $this->partner,
        ]);
    }
}
