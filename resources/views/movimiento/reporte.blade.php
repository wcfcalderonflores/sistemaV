@extends('adminlte::page')
@section('title', 'Reporte Movimiento')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Reporte Movimientos</h4>
@stop

@section('content')
@livewire('movimiento.reporte-movimiento')
@stop

@section('css')
<link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<style>
  th{
    font-size: 0.92rem;
  }
  td{
    font-size: 0.93rem;
  }
  .table-sm td, .table-sm th {
    padding: .1rem;
  }
  .form-control{
    border-radius: 0%;
  }
</style>
@stop
@section('js')
@livewireScripts
<script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
<script>
  window.addEventListener('show-form', event =>{
    //window.open("http://www.desarrolloweb.com" , "ventana1" , "width=1200,height=700,scrollbars=NO")
    window.open(event.detail,this.target,'width=800,height=850,top=120,left=250,toolbar=no,location=no,status=no,menubar=no')
    //$('#form').modal('show');
  });
  $(document).ready(function(){
        toastr.options = {
            "progressBar": true,
            "positionClass": "toast-top-right",
        }
        window.addEventListener('toastr', event =>{
            toastr.success(event.detail.message,'Exito!');
        
        });
        window.addEventListener('toastr-error', event =>{
            toastr.error(event.detail.message,'Error!!!');
        
        });
        window.addEventListener('confirmar', event =>{
            $('#confirmar').modal('show');
        
        });
    });
</script>
@stop