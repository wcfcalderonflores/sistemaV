@extends('adminlte::page')
@section('title', 'Tarjeta')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Registrar Venta</h4>
@stop

@section('content')
    @livewire('venta.registro')
@stop


@section('css')
<link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<style>
    .content-header {
        padding: 10px .5rem;
    }
    .h5, h5 {
        font-size: 1.06rem;
    }
    .mb-1, .my-1 {
    margin-top: 0.6rem;
    }
    .mb-3, .my-3 {
        margin-bottom: 0.2rem!important;
    }
    .form-control, .input-group-text {
        height: calc(2rem);
        border-radius: 0%;
        padding: 0.175rem 0.75rem;
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
        window.addEventListener('hide-form', event =>{
            $('#form').modal('hide');
            toastr.success(event.detail.message,'Exito!');
        
        });
        window.addEventListener('toastr', event =>{
            toastr.success(event.detail.message,'Exito!');
        
        });
        window.addEventListener('toastr-error', event =>{
            toastr.error(event.detail.message,'Error!');
        
        });
    });
</script>
<script>
    window.addEventListener('show-form', event =>{
        $('#form').modal('show');
    });
    window.addEventListener('modalDescuento', event =>{
        $('#modalDescuento').modal('show');
    });
    window.addEventListener('modalDescuento-cerrar', event =>{
        $('#modalDescuento').modal('hide');
    });
</script>
@stop