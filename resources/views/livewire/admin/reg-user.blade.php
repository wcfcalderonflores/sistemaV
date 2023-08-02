
<div class="card">
    <div class="card-body">
        @if ($tipo == 'reg')
            {!! Form::open(['route'=> 'admin.users.store', 'method'=>'post']) !!}
        @else
        {!! Form::model($user,['route'=> ['admin.users.update',$user], 'method'=>'put']) !!}
        @endif
        
            <div class="form-group">
                {!! Form::label('name','Nombre') !!}
                {!! Form::text('name', null, ['class'=> 'form-control'.($errors->has('name') ? ' is-invalid' : null),'placeholder'=>'Ingrese nombre']) !!}
                @error('name')
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('name','Email') !!}
                {!! Form::email('email', null, ['class'=>'form-control'.($errors->has('email') ? ' is-invalid' : null),'placeholder'=>'Ingrese email']) !!}
                @error('email')
                    <span class="text-danger">{{$message}}</span>
                @enderror 
            </div>
            <div class="form-group">
                {!! Form::label('name','Rol') !!}
                @foreach ($roles as $role)
                    <div>
                        <label for="">
                            {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                            {{$role->name}}
                        </label>
                    </div>
                @endforeach
                @error('roles')
                    <span class="text-danger">{{$message}}</span>
                @enderror 
            </div>
            @if ($tipo != 'reg')
                <h2 class="h3">Lista de permisos</h2>
                <div class="form-group">
                    @foreach ($permissions as $permission)
                        <div style="display:inline;margin-right:10px">
                            <label for="">
                                @php($encontrado = false)
                                @foreach ($user->getPermissionsViaRoles() as $item)
                                    @if ($permission->id == $item->id )
                                        {!! Form::checkbox('permission', $permission->id, true, ['class'=>'mr-1','disabled']) !!}
                                        {{$permission->description}}
                                        @php($encontrado = true)
                                        @break
                                    @endif
                                @endforeach
                                
                                @if ($encontrado==false)
                                
                                    {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
                                    {{$permission->description}}
                                    
                                @endif                        
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                {!! Form::label('name','Contraseña') !!}
                {!! Form::password('password', ['class'=>'form-control'.($errors->has('password') ? ' is-invalid' : null),'placeholder'=>'Ingrese contraseña']) !!}
                @error('password')
                    <span class="text-danger">{{$message}}</span>
                @enderror 
            </div>
            {!! Form::submit($tipo == 'reg' ?'Crear usuario':'Actualizar usuario', ['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>

