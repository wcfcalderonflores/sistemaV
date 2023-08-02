@extends('adminlte::page')
@section('title', 'Tarjeta')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Comprobantes</h4>
@stop

@section('content')
@livewire('comprobante.list-comprobante')
@stop
@section('css')
<link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<style>
    .form-control {
        height: calc(2.20rem);
        border-radius: 0%;
    }
    label{
        font-size: 14px;
    }
    .form-group{
        margin-bottom: 0.6rem;
    }
    .card-body {
        padding: 0px 1.25rem; 
        margin-bottom: 12px;
    }
    .table td, .table th {
        padding: .2rem;
        font-size: 0.92rem;
        text-align: center;
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
            $('#registroComprobanteModal').modal('hide');
            toastr.success(event.detail.message,'Exito!');
        });
        window.addEventListener('hide-form-config', event =>{
            $('#registroConfigComprobanteModal').modal('hide');
            toastr.success(event.detail.message,'Exito!');
        });
        /*window.addEventListener('toastr', event =>{
            toastr.success(event.detail.message,'Exito!');
        
        });*/
        window.addEventListener('toastr-error', event =>{
            toastr.error(event.detail.message,'Error!!!');
        
        });
    });
</script>
<script>
    Livewire.on('abrirModal', tipo=>{
        Livewire.emit('registro-comprobante-tipo',tipo);
        $('#registroComprobanteModal').modal('show');
    });
    Livewire.on('cerrarModal',()=>{
        $('#registroComprobanteModal').modal('hide');
    });
    Livewire.on('abrirModalConfig',(tipo,id)=>{
        Livewire.emit('config-comprobante-tipo',tipo,id);
        $('#registroConfigComprobanteModal').modal('show');
    });
    Livewire.on('cerrarModalConfig',()=>{
        $('#registroConfigComprobanteModal').modal('hide');
    });
</script>

@stop