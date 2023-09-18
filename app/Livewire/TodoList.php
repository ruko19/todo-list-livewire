<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{


    use WithPagination;

    public $name;
    public $search = '';

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


    // function delete
    public function delete(Todo $todo)
    {

        $todo->delete();
    }
    public function render()
    {

        $todos = Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);

        return view('livewire.todo-list', compact('todos'));
    }
}
