<div class="card">
    <div class="card-body table-responsive-sm">
        <table class="table table-striped">
            <thead>
                <th>ID</th>
                <th>Role</th>
                <th colspan="2"></th>
            </thead>
            <tbody>
                @foreach ($roles as $index =>$role)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$role->name}}</td>
                        <td width="10px">
                         <a href="{{route('admin.roles.edit',$role)}}" class="btn btn-sm btn-primary">Editar</a>
                        </td>
                        <!--td width="10px">
                            <form action="{{route('admin.roles.destroy',$role)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td-->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
