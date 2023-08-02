<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserController extends Controller
{
    public $search='texto de prueba';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
  
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $roles = Role::all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|unique:users',
            'password' => 'required',
            'roles' => 'required',
            //'password2' => 'required'
        ]);
        //User::create($request->all());
        $user  = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole($request->roles); //assignRole asigna roles como matriz
        return redirect()->route('admin.users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        $roles = Role::all();
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //$user->name = $request->name;
        //$user->email = $request->email;
        //$user->password = $request->password;
        $request->validate([
            'name'=> 'required',
            'email'=> "required|unique:users,email,$user->id",
            'roles' => 'required',
        ]);

        //$user->update($request->all());
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password =="" ? $user->password : bcrypt($request->password),
        ]);
        $user->roles()->sync($request->roles); // o syncRoles
        $user->permissions()->sync($request->permissions);
        return redirect()->route('admin.users')->with('info','Usuario actualizado con exito!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('admin.users')->with('info','Usuario eliminado con exito!!');
        } catch (\Throwable $th) {
            return redirect()->route('admin.users')->with('info',$th->errorInfo[2]);
    }
        
        
    }
}
