<div class="card">
    <div class="card-body">
        @if ($tipo=='create')
            {!! Form::open(['route'=>'admin.roles.store']) !!}
        @else
            {!! Form::model($role,['route'=>['admin.roles.update',$role], 'method'=>'put']) !!}
        @endif
        
            <div class="form-group">
                {!! Form::label('name', 'Nombre') !!}
                {!! Form::text('name', null, ['class'=>'form-control','placeholder'=>'Ingrese nombre del rol']) !!}
                @error('name')
                    <small class="text-danger">
                        {{$message}}
                    </small>
                @enderror
            </div>
            <h2 class="h3">Lista de permisos</h2>
            <div class="form-group">
                @foreach ($permissions as $permission)
                    <div style="display:inline;margin-right:10px">
                        <label for="">
                            {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
                            {{$permission->description}}
                        </label>
                    </div>
                @endforeach
                @error('permissions')
                    <small class="text-danger">{{$message}}</small>
                @enderror 
            </div>
            {!! Form::submit($tipo=='create' ? 'Crear rol' : 'Editar rol', ['class'=>'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
</div>
