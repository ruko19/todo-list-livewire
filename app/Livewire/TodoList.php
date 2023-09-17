<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;

class TodoList extends Component
{

    public $name;

    public function create()
    {

        $validated = $this->validate([
            'name' => 'required|min:3'
        ]);

        Todo::create($validated);
        $this->reset('name');

        session()->flash('success', 'Created');
    }
    public function render()
    {


        return view('livewire.todo-list');
    }
}
