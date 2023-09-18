<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{


    use WithPagination;

    public $name;

    public function create()
    {

        // validation
        $validated = $this->validate([
            'name' => 'required|min:3'
        ]);

        // create todo
        Todo::create($validated);
        // reset Input
        $this->reset('name');

        // message success
        session()->flash('success', 'Created');
    }
    public function render()
    {
        $todos = Todo::latest()->paginate(5);

        return view('livewire.todo-list', compact('todos'));
    }
}
