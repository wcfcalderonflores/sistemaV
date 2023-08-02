@extends('adminlte::page')
@section('title', 'Cerrar Caja')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Cerrar Caja</h4>
@stop

@section('content')
@livewire('caja.caja-cierre')
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
</style>
@stop
@section('js')
@livewireScripts
<script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
<script>
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