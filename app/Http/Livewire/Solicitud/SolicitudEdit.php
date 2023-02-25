<?php

namespace App\Http\Livewire\Solicitud;

use App\Models\Endorsement;
use App\Models\Partner;
use App\Models\Solicitud;
use App\Models\Warranty;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;


class SolicitudEdit extends Component
{
    use WithFileUploads;

    public Partner $partner;
    public Solicitud $solicitud;
    /* Avales */
    public Endorsement $endorsement;
    public $endorsements;
    public $aval;
    public $inputs = [];
    public $i = -1;
    public $saveNewAval = false;
    /* End aval */
    /* Garantías */
    public $warranties;
    public $inputsWarranty = [];
    public $j = -1;
    /* En garantías */
    protected function rules()
    {
        $rules = [
            'solicitud.date_solicitud' => ['required', 'date'],
            'solicitud.date_payment' => ['required', 'date'],
            'solicitud.period' => ['required'],
            'solicitud.mount' => ['required', 'numeric'],
            'solicitud.concept' => ['nullable'],
            'solicitud.condition' => ['required'],
            'solicitud.folio' => ['required', 'numeric', 'unique:solicituds,folio,' . $this->solicitud->id],
            'endorsement.names' => [
                Rule::requiredIf($this->saveNewAval)
            ],
            'endorsement.surnames' => [
                Rule::requiredIf($this->saveNewAval)
            ],
            'endorsement.phone' => [
                Rule::requiredIf($this->saveNewAval)
            ],
            'endorsement.address' => [
                Rule::requiredIf($this->saveNewAval)
            ],
            'endorsement.key_ine' => [
                Rule::requiredIf($this->saveNewAval)
            ],
        ];
        foreach ($this->inputs as $key => $value) {
            $rules = array_merge($rules, [
                'aval.' . $value => 'required',
            ]);
        }

        foreach ($this->inputsWarranty as $key => $value) {
            $rules = array_merge($rules, [
                'warranties.' . $value . '.type' => ['required'],
                'warranties.' . $value . '.description' => ['nullable', 'max:255'],
                'warranties.' . $value . '.url_document' => ['nullable', 'max:2048'],
            ]);
        }

        return $rules;
    }

    public function mount(Solicitud $solicitud, Endorsement $endorsement)
    {
        $this->endorsements = Endorsement::orderBy('names')->get();
        $this->solicitud = $solicitud;
        $this->partner = $solicitud->partner;
        $this->endorsement = $endorsement;
    }

    public function updateDate()
    {
        $this->solicitud->date_payment = $this->solicitud->date_solicitud->addMonths($this->solicitud->period);
    }
    protected $listeners = [
        'showModal' => 'showModal',
        'display-modal' => 'toggleModal',
        'hide-form' => 'hideModal',
    ];
    public function save()
    {
        $this->validate();
        $this->solicitud->save();
        //Agregar aval
        $this->solicitud->endorsements()->attach($this->aval);
        //Agregar garantías
        if (!empty($this->warranties)) {
            foreach ($this->warranties as $warranty) {
                $newWarranty = new Warranty();
                $newWarranty->solicitud_id = $this->solicitud->id;
                if (!empty($warranty['url_document'])) {
                    $newWarranty->url_document = $warranty['url_document']->store('/warranties', 'public');
                }
                $newWarranty->description = $warranty['description'] ?? '';
                $newWarranty->type = $warranty['type'] ?? '';
                $newWarranty->save();
            }
        }
        return redirect()->route('partners.solicitud.show', $this->solicitud);
    }

    //Avales
    public function toggleModal()
    {
        $this->dispatchBrowserEvent('show-modal');
    }

    public function hideModal()
    {
        $this->clearEndorsement();
        $this->dispatchBrowserEvent('hide-modal');
    }
    public function clearEndorsement()
    {
        $this->endorsement = new Endorsement();
    }

    public function add($i)
    {
        $i = $i + 1;
        $this->i = $i;
        array_push($this->inputs, $i);
    }

    public function remove($i)
    {
        unset($this->inputs[$i]);
        unset($this->aval[$i]);
    }

    public function saveEndorsement()
    {
        $this->saveNewAval = true;
        $this->validate([
            'endorsement.names' => ['required'],
            'endorsement.surnames' => ['required'],
            'endorsement.phone' => ['nullable'],
            'endorsement.key_ine' => ['nullable'],
        ]);
        $this->endorsement->save();
        $this->saveNewAval = false;
        $this->endorsements = Endorsement::orderBy('names')->get();
        $this->endorsement = new Endorsement();
        $this->hideModal();
        $this->dispatchBrowserEvent('save-endorsement', ['message' => 'Se ha registrado con éxito el aval']);
        return redirect()->back();
    }

    /* Garantías */
    public function addWarranty($j)
    {
        $j = $j + 1;
        $this->j = $j;
        array_push($this->inputsWarranty, $j);
    }

    public function removeWarranty($j)
    {
        unset($this->inputsWarranty[$j]);
        unset($this->warranties[$j]);
    }
    /* End garantías */

    /* Quit endorsement, but not delete */
    public function quitEndorsement(Endorsement $endorsement)
    {
        $this->solicitud->endorsements()->detach($endorsement);
        $this->solicitud->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se ha desvinculado con el aval']);
    }
    /* Destroy warranty */
    public function destroyWarranty(Warranty $warranty)
    {
        if ($warranty->url_document) {
            if (Storage::disk('public')->exists($warranty->url_document)) {
                Storage::disk('public')->delete($warranty->url_document);
            }
        }
        $warranty->delete();
        $this->solicitud->refresh();
        $this->dispatchBrowserEvent('message', ['message' => 'Se eliminó la garantía']);
    }

    public function render()
    {
        return view('livewire.solicitud.solicitud-edit', [
            'solicitud' => $this->solicitud,
        ]);
    }
}
