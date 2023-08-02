<?php

namespace App\Http\Livewire\Alex;

use Livewire\Component;

class Prueba extends Component
{   
    public $tasks = [];
    public $newTask = '';
    
    public function render()
    {
        return view('livewire.alex.prueba');
    }

    public function addTask()
    {
        if ($this->newTask != '') {
            array_push($this->tasks, $this->newTask);
            $this->newTask = '';
        }
    }
}
