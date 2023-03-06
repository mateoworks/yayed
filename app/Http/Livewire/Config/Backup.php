<?php

namespace App\Http\Livewire\Config;

use Livewire\Component;
use Spatie\Backup\Commands\BackupCommand;

class Backup extends Component
{
    public function backup()
    {
        $backupCommand = new BackupCommand();
        $backupCommand->handle();

        session()->flash('message', 'La copia de seguridad se ha realizado correctamente.');
    }
    public function render()
    {
        return view('livewire.config.backup');
    }
}
