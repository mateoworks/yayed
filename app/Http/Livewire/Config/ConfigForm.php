<?php

namespace App\Http\Livewire\Config;

use App\Models\Config;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigForm extends Component
{
    use WithFileUploads;
    public $periodo;
    public $logotipo;
    public $logoGuardar;
    public function rules()
    {
        return ['periodo' => 'required'];
    }
    public function mount()
    {
        $periodoLocal = Config::where('key', 'periodo')->first();
        $this->periodo = $periodoLocal->value ?? '';
        $this->logoGuardar = Config::where('key', 'logo')->first();
    }

    public function deleteImg()
    {
        $this->logoGuardar->delete();
        $this->logoGuardar = null;
    }
    public function save()
    {
        $periodo = Config::firstOrNew(
            ['key' =>  'periodo'],
        );
        $periodo->value = $this->periodo;
        $periodo->save();

        $logo = Config::firstOrNew(
            ['key' => 'logo'],
        );
        if ($this->logotipo) {
            $logo->value = $this->logotipo->store('/config', 'public');
            $logo->save();
        }
    }
    public function render()
    {
        return view('livewire.config.config-form');
    }
}
