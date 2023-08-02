@extends('adminlte::page')
@section('title', 'Movimientos')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Registro de Movimientos</h4>
@stop

@section('content')
@livewire('movimiento.registro-movimiento')
@stop

@section('css')
<link href="{{ asset('vendor/toastr/toastr.min.css') }}" rel="stylesheet"/>
<style>
    .content-header {
        padding: 10px .5rem;
    }
    .h5, h5 {
        font-size: 1rem;
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
    }
    label:not(.form-check-label):not(.custom-file-label) {
        font-weight: 520;
    }
    .badge{
        font-size: 0.5rem;
    }
    .table-sm td, .table-sm th {
    padding: .1rem;
}
</style>
@stop

@section('js')
@livewireScripts
<script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('vendor/toastr/sweetalert2@11.js')}}"></script>
  <script>
    Livewire.on( 'messageEliminar', movimiento=>{
      //$('#confirmar').modal('show');
      Swal.fire({
      title: 'Confirmar',
      text: "Desea eliminar movimiento!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar!'
    }).then((result) => {
      if (result.isConfirmed) {
        Livewire.emitTo('movimiento.registro-movimiento','eliminar',movimiento);
        /*Swal.fire(
          'Deleted!',
          'Your file has been deleted.',
          'success'
        )*/
      }
    })
    });
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
            toastr.error(event.detail.message,'Error');
        
        });
    });
</script>
<script>
    window.addEventListener('show-form', event =>{
            $('#form').modal('show');
        });
</script>
@stop