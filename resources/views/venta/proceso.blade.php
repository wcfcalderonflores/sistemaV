@extends('adminlte::page')
@section('title', 'Venta Proceso')

@section('content_header')
    <h4 style="margin:0px">Ventas en proceso</h4>
@stop

@section('content')
@if (count($ventas)>0)
<div class="card">
    <div class="card-boy table-responsive-sm p-4">
        
        <table class="table table-sm">
            <thead style="background-color: #d8dfe6;">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Comprobante</th>
                <th scope="col">Cliente</th>
                <th scope="col">Fecha / Hora</th>
                <th scope="col" colspan="3">Vendedor</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $index=>$venta)
                <tr>
                    <th scope="row">{{$index+1}}</th>
                    <td>{{$venta->serie}} - {{$venta->numero_comprobante}}</td>
                    <td>{{$venta->nombre}} {{$venta->apellido_paterno}} {{$venta->apellido_materno}}</td>
                    <td>{{date("d/m/Y h:i:A", strtotime( $venta->created_at))}}</td>
                    <td>{{$venta->name}}</td>
                    <td style="width: 5px"><a href="{{route('venta.edit',$venta->id)}}" class="btn btn-secondary btn-sm">Editar</a></td>
                    <td style="width: 5px">
                        <form action="{{route('venta.edit',$venta->id)}}" method="post">
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
