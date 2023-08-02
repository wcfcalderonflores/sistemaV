<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class ListRole extends Component
{
    public function render()
    {   
        $roles = Role::all();
        return view('livewire.admin.list-role', compact('roles'));
    }
}
