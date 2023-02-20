<?php

namespace App\Http\Livewire\Movement;

use App\Models\Movement;
use Livewire\Component;
use Livewire\WithPagination;

class MovementsList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public function render()
    {
        return view('livewire.movement.movements-list', [
            'movements' => Movement::where('concept', 'LIKE', "%$this->search%")
                ->latest('date_movement')
                ->paginate(),
        ]);
    }
}
