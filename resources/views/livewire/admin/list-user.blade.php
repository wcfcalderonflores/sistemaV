<div>
    <div class="card">
        <div class="card-header col-md-12">
            <div class="row">
                <div  class="col-md-2">
                    <a href="#" wire:click.prevent="addNew" class="btn btn-secondary btn-block"> <i class="fa fa-plus-circle mr-1"></i> Crear Usuario</a>
                </div>
                <div  class="col-md-10">
                    <input wire:model="search" class="form-control" placeholder="Ingrese nombre">
                </div>
            </div>
            
        </div>
        @if ($users->count())
            <div class="card-body table-responsive-sm">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Fecha Creación</th>
                            <th colspan="2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->created_at}}</td> 
                                <td width="5px"><a class="btn btn-primary btn-sm" href="{{route('admin.users.edit',$user)}}">Editar</a></td> 
                                <td wisth="5px">
                                    <a href="#" wire:click.prevent="eliminar({{$user}})" class="btn btn-danger btn-sm">Eliminar</a>
                                </td>  
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                <div class="footer">{{$users->links()}}</div> 
            </div>
            
        @else
            <div class="card-body"><strong>No hay registros</strong></div>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!--form wire:submit.prevent="createUser"-->
            @if ($tipo=='create')
                {!! Form::open(['wire:submit.prevent'=>'createUser','autocomplete'=>'off']) !!}
            @else
                {!! Form::model($user,['wire:submit.prevent'=>'editarUser', 'method'=>'put']) !!}
            @endif
              
        
                <div class="form-group">
                    {!! Form::label('name','Nombre') !!}
                    {!! Form::text('name', null, ['class'=> 'form-control'.($errors->has('name') ? ' is-invalid' : null),'placeholder'=>'Ingrese nombre','wire:model.defer'=>"state.name"]) !!}
                    @error('name')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('name','Email') !!}
                    {!! Form::email('email', null, ['class'=>'form-control'.($errors->has('email') ? ' is-invalid' : null),'placeholder'=>'Ingrese email','wire:model.defer'=>"state.email"]) !!}
                    @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror 
                </div>
                <div class="form-group">
                    {!! Form::label('name','Rol') !!}
                    @foreach ($roles as $role)
                        <div>
                            <label>
                                
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}" wire:model.defer="selectedtypes"  class="form-checkbox h-6 w-6 text-green-500">
                                {{$role->name}}
                            </label>
                        </div>
                    @endforeach
                    @error('roles')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                @if ($tipo == 'edit')
                    <h2 class="h3">Lista de permisos</h2>
                    <div class="form-group">
                        @foreach ($permissions as $permission)
                            <div style="display:inline;margin-right:10px">
                                <label for="">
                                    @php($encontrado = false)
                                    @foreach ($usuario->getPermissionsViaRoles() as $item)
                                        @if ($permission->id == $item->id )
                                            {!! Form::checkbox('permission', $permission->id, true, ['class'=>'mr-1','disabled']) !!}
                                            {{$permission->description}}
                                            @php($encontrado = true)
                                            @break
                                        @endif
                                    @endforeach
                                    
                                    @if ($encontrado==false)
                                    
                                        {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1','wire:model.defer'=>'selectedtypes2']) !!}
                                        {{$permission->description}}
                                        
                                    @endif                        
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="form-group">
                    {!! Form::label('name','Contraseña') !!}
                    {!! Form::password('password', ['class'=>'form-control'.($errors->has('password') ? ' is-invalid' : null),'placeholder'=>'Ingrese contraseña','wire:model.defer'=>"state.password"]) !!}
                    @error('password')
                        <div class="invalid-feedback">{{$message}}</div>
                    @enderror 
                </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {!! Form::submit($tipo == 'create' ?'Crear usuario':'Actualizar usuario', ['class'=>'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
        </div>
        </div>
    </div>
</div>

