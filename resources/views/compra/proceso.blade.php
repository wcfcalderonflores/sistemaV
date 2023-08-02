@extends('adminlte::page')
@section('title', 'Venta Proceso')

@section('content_header')
    <h4 style="margin:0px">Compras en proceso</h4>
@stop

@section('content')
@if (count($compras)>0)
<div class="card">
    <div class="card-boy table-responsive-sm p-4">
        
        <table class="table table-sm">
            <thead style="background-color: #d8dfe6;">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Comprobante</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Fecha</th>
                <th scope="col" colspan="3">Usuario</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($compras as $index=>$compra)
                <tr>
                    <th scope="row">{{$index+1}}</th>
                    <td>[{{$compra->comprobante}}]  {{$compra->numero_comprobante}}</td>
                    <td>{{$compra->nombre}} {{$compra->apellido_paterno}} {{$compra->apellido_materno}}</td>
                    <td>{{date("d/m/Y", strtotime( $compra->fecha_compra))}}</td>
                    <td>{{$compra->name}}</td>
                    <td style="width: 5px"><a href="{{route('compra.edit',$compra->id)}}" class="btn btn-secondary btn-sm">Editar</a></td>
                    <td style="width: 5px">
                        <form action="{{route('compra.destroy',$compra->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr> 
                @endforeach
            </tbody>
          </table> 
    </div>
</div>
@else
        <div class="alert alert-dark" role="alert">
            No se encontro registros
        </div>  
        @endif

@stop

@section('css')
@stop
