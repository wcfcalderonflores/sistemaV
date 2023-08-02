@extends('adminlte::page')
@section('title', 'Recibir Caja')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Ajustar Stock</h4>
@stop

@section('content')
@livewire('ajustar-stock.registro')
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
  .table td, .table th {
    padding: .3rem;
  }
  .card-body {
    padding: 1rem;
  }
  .form-control, .input-group-text {
        height: calc(2rem);
        border-radius: 0%;
    }
    .buscador{
        position: absolute;
        left: 5px;
        top: 65px;
        z-index: 1;
        width: inherit;
        background-color: white;
    }
    .buscador2{
        position: absolute;
        left: 5px;
        top: 35px;
        z-index: 1;
        width: inherit;
        background-color: white;
    }
    .resultado:hover{
        background-color: bisque;
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 550;
    }
    .badge{
        font-size: 0.7rem;
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