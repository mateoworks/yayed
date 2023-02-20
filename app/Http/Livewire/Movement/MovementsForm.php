<?php

namespace App\Http\Livewire\Movement;

use App\Models\CategoryMovement;
use App\Models\Movement;
use Livewire\Component;

class MovementsForm extends Component
{
    public Movement $movement;
    public function mount(Movement $movement)
    {
        $this->movement = $movement;
    }
    public function rules()
    {
        return [
            'movement.type' => ['required'],
            'movement.concept' => ['nullable'],
            'movement.amount' => ['required', 'numeric'],
            'movement.description' => ['nullable'],
            'movement.date_movement' => ['required', 'date'],
            'movement.image' => ['nullable'],
            'movement.category_movement_id' => ['required'],
        ];
    }
    public function save()
    {
        $this->validate();
        $category = CategoryMovement::find($this->movement->category_movement_id);
        if (!$category) {
            $category = CategoryMovement::create(['name' => $this->movement->category_movement_id]);
            $this->movement->category_movement_id = $category->id;
        }
        $this->movement->save();
        return redirect()->route('movements.index');
    }
    public function render()
    {
        return view('livewire.movement.movements-form', [
            'categorias' => CategoryMovement::all(),
        ]);
    }
}
