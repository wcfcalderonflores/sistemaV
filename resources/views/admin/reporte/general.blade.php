@extends('adminlte::page')
@section('title', 'Reporte General')

@section('content_header')
    <h4 style="margin:0px">Reporte General</h4>
@stop

@section('content')
<div class="card">
    <div class="card-body" style="padding-bottom: 0px;">
        <div class="row justify-content-center">
            <div class="col-md-6 mr-3 table-responsive-sm">
                <table class="table table-sm" >
                    <thead style="background-color: #343a40;">
                    <tr style="color: white">
                        <th scope="col">#</th>
                        <th scope="col" class="text-center">MOVIMIENTO</th>
                        <th scope="col" class="text-center">TOTAL</th>

                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td>1</td>
                        <td class="text-center">Ventas</td>
                        <td class="text-center"><span class="badge badge-success" style="font-size: 95%">{{number_format($ventas[0]->total,2)}}</span></td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td class="text-center">Ingresos</td>
                        <td class="text-center"><span class="badge badge-success" style="font-size: 95%">{{number_format($movimientos[0]->pago,2)}}</span></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td class="text-center">Gastos</td>
                        <td class="text-center"><span class="badge badge-danger" style="font-size: 95%">{{number_format($movimientos[0]->debe,2)}}</span></td>
                    </tr>
                    <tr style="background-color: #ecc965">
                        <td></td>
                        <td class="text-center"><strong>Total : </strong></td>
                        @php($total = $ventas[0]->total + $movimientos[0]->pago - $movimientos[0]->debe)
                        <td class="text-center"><span class="badge badge-{{$total < 0 ? 'danger' : 'success'}}" style="font-size: 95%">{{number_format($total,2)}}</span></td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
  th{
    font-size: 0.92rem;
  }
  td{
    font-size: 0.93rem;
  }
</style>
@stop
@section('js')
@stop