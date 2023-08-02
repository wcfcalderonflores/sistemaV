@extends('adminlte::page')
@section('title', 'Venta Proceso')

@section('content_header')
    <h4 style="margin:0px">Ajuste de Stock en proceso</h4>
@stop

@section('content')
@if (count($ajustes)>0)
<div class="card">
    <div class="card-boy table-responsive-sm p-4">
        
        <table class="table table-sm">
            <thead style="background-color: #d8dfe6;">
              <tr>
                <th scope="col">#</th>
                <th scope="col" class="text-center">Tipo</th>
                <th scope="col" class="text-center">Referencia</th>
                <th scope="col" class="text-center">Fecha / Hora</th>
                <th scope="col" class="text-center">Cantidad Un.</th>
                <th scope="col" class="text-center">Cantidad Rec.</th>
                <th colspan="2"></th>
              </tr>
            </thead>
            <tbody>
                @foreach ($ajustes as $index=>$ajuste)
                <tr>
                    <th scope="row">{{$index+1}}</th>
                    <td class="text-center">{{$ajuste->tipo_ajuste == '1' ? 'Vencimiento' : ($ajuste->tipo_ajuste == '2' ? 'Pérdida' : 'Otro')}}</td>
                    <td class="text-center">{{$ajuste->referencia}}</td>
                    <td class="text-center">{{date("d/m/Y h:i:A", strtotime( $ajuste->fecha))}}</td>
                    <td class="text-center">{{$ajuste->cantidad_unidades}}</td>
                    <td class="text-center">{{number_format($ajuste->cantidad_recuperada,2)}}</td>
                    <td style="width: 5px"><a href="{{route('ajuste.index.edit',$ajuste->id)}}" class="btn btn-secondary btn-sm">Editar</a></td>
                    <td style="width: 5px">
                        <form action="{{route('ajuste.destroy',$ajuste->id)}}" method="post">
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
