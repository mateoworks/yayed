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
    public $activarSolicitud;
    public function rules()
    {
        return ['periodo' => 'required', 'activarSolicitud' => 'nullable'];
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
        if ($this->periodo != '') {
            $periodo = Config::firstOrNew(
                ['key' =>  'periodo'],
            );
            $periodo->value = $this->periodo;
            $periodo->save();
        }
        $solicitud = Config::firstOrNew(['key' => 'solicitud']);
        $solicitud->value = $this->activarSolicitud;
        $solicitud->save();

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
