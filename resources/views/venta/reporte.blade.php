@extends('adminlte::page')
@section('title', 'Reporte Venta')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Reporte venta</h4>
@stop

@section('content')
@livewire('venta.reporte')
@stop

@section('css')
<style>
  th{
    font-size: 0.92rem;
  }
  td{
    font-size: 0.93rem;
  }
  .form-control{
    border-radius: 0%;
  }
  
</style>
@stop
@section('js')
@livewireScripts
<script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
<script src="{{ asset('vendor/toastr/sweetalert2@11.js')}}"></script>
  <script>
      Livewire.on( 'confirmarSunat', (id,msj)=>{
        Swal.fire({
        title: 'Confirmar',
        text: msj,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar!'
      }).then((result) => {
          if (result.isConfirmed) {
              console.log('alexlo!!!!');
          }
      })
      });
  </script>
<script>
  window.addEventListener('show-form', event =>{
    //window.open("http://www.desarrolloweb.com" , "ventana1" , "width=1200,height=700,scrollbars=NO")
    window.open(event.detail,this.target,'width=400,height=450,top=120,left=500,toolbar=no,location=no,status=no,menubar=no')
    //$('#form').modal('show');
  });
</script>
@stop