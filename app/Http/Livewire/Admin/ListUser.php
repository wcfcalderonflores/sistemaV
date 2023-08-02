<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListUser extends Component
{   
    public $search;
    public $tipo='create';
    public $state=[];
    public $usuario;
    public $selectedtypes = [];
    public $aux = [];
    public $selectedtypes2 = [];
    use WithPagination;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function addNew(){
        $this->dispatchBrowserEvent('show-form');
        $this->tipo='create';
    }
    public function createUser(Request $request){

        $alexlo = Validator::make($this->state,[
            'name'=> 'required',
            'email'=> "required|unique:users",
            'password' => 'required',
            'roles.*' => 'required',
           
        ])->validate();
        //dd($this->selectedtypes);
        $user  = User::create([
            'name' => $alexlo['name'],
            'email' => $alexlo['email'],
            'password' => bcrypt($alexlo['password'])
        ]);
        
        $user->assignRole($this->selectedtypes);
        //session()->flash('message', 'Usuario creado con éxito!!');
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Usuario creado.']);
        $this->state=[];
        $this->selectedtypes = [];
        return redirect()->back();

    }

    public function editar(User $user){
        $this->dispatchBrowserEvent('show-form');
        $this->tipo='edit';
        $this->state=$user->toArray();
        $this->selectedtypes = $user->roles->pluck('id')->toArray();
        $this->usuario = $user;
    }
    public function editarUser(){
        $alexlo = Validator::make($this->state,[
            'name'=> 'required',
            'email'=> 'required|unique:users,email,'.$this->usuario->id,
           
        ])->validate();
        $this->usuario->update($alexlo);
        if(!empty($alexlo['password'])){
            $alexlo['password']= bcrypt($alexlo['password']);
        }
        $this->usuario->roles()->sync($this->selectedtypes); // o syncRoles
        $this->usuario->permissions()->sync($this->selectedtypes2);
        $this->dispatchBrowserEvent('hide-form', ['message'=>'Usuario actualizado.']);
        return redirect()->back();
    }
    public function eliminar(User $user)
    {   
        try {
            $user->delete();
            $this->resetPage();
            $this->dispatchBrowserEvent('hide-form', ['message'=>'Usuario eliminado.']);
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('toastr-error', ['message'=>'Usuario tiene dependencia.']);
        }
        
        return redirect()->back();
    }

    public function render()
    {   
        //Paginator::useBootstrap();
        $users = User::where('name','LIKE','%'.$this->search.'%')
                        ->orWhere('email','LIKE','%'.$this->search.'%')
                        ->paginate(3);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('livewire.admin.list-user',compact('users','roles','permissions'));
    }
}
