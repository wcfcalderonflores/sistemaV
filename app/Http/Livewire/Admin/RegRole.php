<?php

namespace App\Http\Livewire\Admin;

use Spatie\Permission\Models\Permission;


use Livewire\Component;

class RegRole extends Component
{   
    public $tipo;
    public $role;
    public function render()
    {   
        $permissions = Permission::all();
        return view('livewire.admin.reg-role', compact('permissions'));
    }
}
