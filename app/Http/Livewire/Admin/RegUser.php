<?php

namespace App\Http\Livewire\Admin;

use Laravel\Jetstream\Rules\Role;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class RegUser extends Component
{   
    public $tipo;
    public $user;
    public $roles;
    public function render()
    {   
        $permissions = Permission::all();
        return view('livewire.admin.reg-user', compact('permissions'));
    }
}
