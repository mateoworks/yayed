<?php

namespace App\Http\Livewire\Loan;

use App\Models\Endorsement;
use App\Models\Loan;
use App\Models\Partner;
use App\Models\Warranty;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Luecano\NumeroALetras\NumeroALetras;

class LoansPartnerForm extends Component
{
    use WithFileUploads;
    public Partner $partner;
    public Loan $loan;
    public Endorsement $endorsement;

    public $endorsements;

    public $noMeses;

    public $aval;
    public $inputs = [];
    public $i = -1;
    public $saveNewAval = false;

    //public $type, $description, $url_document;
    /* Garantías */
    public $warranties;
    public $inputsWarranty = [];
    public $j = -1;

    public function rules()
    {
        $rules = [
            'loan.amount' => ['required', 'numeric'],
            'loan.interest' => ['required', 'numeric'],
            'loan.date_made' => ['required', 'date'],
            'loan.date_payment' => ['required', 'date'],
            'endorsement.names' => [
                Rule::requiredIf($this->saveNewAval)
            ],
            'endorsement.surnames' => [
                Rule::requiredIf($this->saveNewAval)
            ],
            'endorsement.phone' => [
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

    protected $listeners = [
        'showModal' => 'showModal',
        'display-modal' => 'toggleModal',
        'hide-form' => 'hideModal',
    ];

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

    public function mount(Loan $loan, Endorsement $endorsement)
    {
        $this->endorsements = Endorsement::orderBy('names')->get();
        $this->loan = $loan;
        $this->loan->interest = 2;
        $this->loan->date_made = date("Y-m-d");
        $this->endorsement = $endorsement;
        $this->noMeses = 1;
    }

    public function updateDate()
    {
        $this->loan->date_payment = $this->loan->date_made->addMonths($this->noMeses);
    }

    public function updateNoMonth()
    {
        $noPeriodos = $this->loan->date_made->floatDiffInMonths($this->loan->date_payment);
        $this->noMeses = round($noPeriodos, 0);
    }

    public function toggleModal()
    {
        $this->dispatchBrowserEvent('show-modal');
    }

    public function hideModal()
    {
        $this->clearEndorsement();
        $this->dispatchBrowserEvent('hide-modal');
    }

    public function render()
    {
        return view('livewire.loan.loans-partner-form', [
            'partner' => $this->partner,
            'endorsements' => $this->endorsements,
        ]);
    }
    public function save()
    {
        $formatter = new NumeroALetras();
        $this->validate();
        $this->loan->number = uniqid();
        $this->loan->partner_id = $this->partner->id;
        $this->loan->amount_letter = $formatter->toWords($this->loan->amount);
        $this->loan->save();
        //Agregar aval
        $this->loan->endorsements()->sync($this->aval);
        //Agregar garantías
        if (!empty($this->warranties)) {
            foreach ($this->warranties as $warranty) {
                $newWarranty = new Warranty();
                $newWarranty->loan_id = $this->loan->id;
                if (!empty($warranty['url_document'])) {
                    $newWarranty->url_document = $warranty['url_document']->store('/warranties', 'public');
                }
                $newWarranty->description = $warranty['description'] ?? '';
                $newWarranty->type = $warranty['type'] ?? '';
                $newWarranty->save();
            }
        }
        return redirect()->route('loans.show', $this->loan);
    }
    public function clearEndorsement()
    {
        $this->endorsement = new Endorsement();
    }

    public function saveEndorsement()
    {
        $this->saveNewAval = true;
        $this->validate([
            'endorsement.names' => ['required'],
            'endorsement.surnames' => ['required'],
            'endorsement.phone' => ['nullable'],
        ]);
        $this->endorsement->save();
        $this->saveNewAval = false;
        $this->endorsements = Endorsement::orderBy('names')->get();
        $this->endorsement = new Endorsement();
        $this->hideModal();
        $this->dispatchBrowserEvent('save-endorsement', ['message' => 'Se ha registrado con éxito el aval']);
        return redirect()->back();
    }

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
}