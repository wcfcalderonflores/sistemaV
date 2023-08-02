@extends('adminlte::page')
@section('title', 'Recibir Caja')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Crear Caja</h4>
@stop

@section('content')
@livewire('admin.crear-caja')
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
  .form-control{
    border-radius: 0%;
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
          $('#registroCajaModal').modal('hide');
          toastr.success(event.detail.message,'Exito!');
      });
      window.addEventListener('toastr-error', event =>{
          toastr.error(event.detail.message,'Error!!!');
      
      });
  });
</script>
<script>
  Livewire.on('abrirModal', tipo=>{
      Livewire.emit('registro-caja-tipo',tipo);
      $('#registroCajaModal').modal('show');
  });
  Livewire.on('cerrarModal',()=>{
      $('#registroCajaModal').modal('hide');
  });
</script>
@stop