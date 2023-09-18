<?php

namespace App\Livewire;

use App\Models\Todo;
use Egulias\EmailValidator\Warning\TLD;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{


    use WithPagination;

    public $name;
    public $search = '';


    public $editingTodoID;

    #[Rule('required|min:3|max:50')]
    public $editingTodoName;


    // function create
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


        $this->resetPage();
    }


    // function delete
    public function delete(Todo $todo)
    {
        $todo->delete();
    }


    public function toggle(Todo $todo)
    {
        $todo->completed = !$todo->completed;
        $todo->save();
    }


    public function edit(Todo $todo)
    {
        $this->editingTodoID = $todo->id;
        $this->editingTodoName = $todo->name;
    }


    public function cancelEdit()
    {
        $this->reset('editingTodoName', 'editingTodoID');
    }


    public function update(Todo $todo)
    {

        $this->validateOnly('editingTodoName');

        Todo::find($this->editingTodoID)->update([
            'name' => $this->editingTodoName
        ]);

        $this->cancelEdit();
    }


    public function render()
    {

        $todos = Todo::latest()->where('name', 'like', "%{$this->search}%")->paginate(5);

        return view('livewire.todo-list', compact('todos'));
    }
}
