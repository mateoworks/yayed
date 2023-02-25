<?php

namespace App\Http\Livewire\Partner;

use App\Models\Document;
use App\Models\Job;
use App\Models\Partner;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use Whoops\Run;

class PartnersForm extends Component
{
    use WithFileUploads;
    public $image;
    public Partner $partner;
    public $type, $file;

    public $inputs = [];
    public $i = -1;

    protected function rules()
    {
        $rules = [
            'partner.number' => [
                'required',
                Rule::unique('partners', 'number')->ignore($this->partner),
            ],
            'partner.names' => ['required', 'min:3', 'max:100'],
            'partner.surname_father' => ['required', 'min:3', 'max:100'],
            'partner.surname_mother' => ['nullable', 'min:3', 'max:100'],
            'partner.address_number' => ['nullable'],
            'partner.barrio' => ['nullable'],
            'partner.cp' => ['nullable'],
            'partner.municipio' => ['nullable'],
            'partner.estado' => ['nullable'],
            'partner.dwelling' => ['nullable'],
            'partner.dependents' => ['nullable'],
            'partner.civil_status' => ['nullable'],
            'partner.phone' => ['nullable', 'max:20'],
            'partner.gender' => ['required'],
            'partner.address' => ['required', 'max:200'],
            'partner.suburb' => ['required', 'max:100'],
            'partner.curp' => [
                'nullable',
                'max:18',
                Rule::unique('partners', 'curp')->ignore($this->partner),
            ],
            'partner.key_ine' => [
                'nullable',
                'max:18',
                Rule::unique('partners', 'key_ine')->ignore($this->partner),
            ],
            'partner.birthday' => ['nullable', 'date'],
            'partner.job_id' => ['required'],
            'partner.email' => ['nullable'],
            'image' => ['nullable', 'image', 'max:2024'],
            'type.*' => [
                'required'
                //Rule::requiredIf($this->i >= 0),
            ],
            'file.*' => [
                Rule::requiredIf($this->i >= 0),
            ],
        ];

        foreach ($this->inputs as $key => $value) {
            $rules = array_merge($rules, [
                'type.' . $value => 'required',
                'file.' . $value => [
                    'required',
                    'mimes:pdf,jpg,png,bmp',
                    'max:2048'
                ],
            ]);
        }
        return $rules;
    }

    public function mount(Partner $partner)
    {
        $this->partner = $partner;
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
    }
    private function resetInputFields()
    {
        $this->type = '';
        $this->file = '';
    }


    public function render()
    {
        return view('livewire.partner.partners-form', [
            'jobs' => Job::all(),
        ]);
    }

    public function deleteImg()
    {
        $this->partner->image = null;
        $this->partner->save();
    }

    public function save()
    {
        $this->validate();
        if ($this->image) {
            $this->partner->image = $this->image->store('/image_partner', 'public');
        }
        $job = Job::find($this->partner->job_id);
        if (!$job) {
            $job = Job::create(['name' => $this->partner->job_id]);
            $this->partner->job_id = $job->id;
        }
        $this->partner->save();
        if (!empty($this->type) && !empty($this->file)) {
            foreach ($this->type as $key => $value) {
                $document = new Document;
                $document->url = $this->file[$key]->store('/document', 'public');
                $document->type = $this->type[$key];
                $document->partner_id = $this->partner->id;
                $document->save();
            }
        }
        Session::flash('message', 'Socio guardado exitosamente');
        Session::flash('alert_class', 'success');
        $this->redirectRoute('partners.index');
    }
    public function deleteDocument(Document $document)
    {
        Storage::disk('public')->delete($document->url);
        $document->delete();
        $this->partner->refresh();
        Session::flash('message', 'Se eliminó el documento');
        Session::flash('alert_class', 'success');
    }
}
