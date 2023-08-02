@extends('adminlte::page')
@section('title', 'Reporte Compra')

@section('content_header')
@livewireStyles
    <h4 style="margin:0px">Reporte compra</h4>
@stop

@section('content')
@livewire('compra.reporte')
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
  .form-control{
    border-radius: 0%;
  }
</style>
@stop
@section('js')
@livewireScripts
<script>
  window.addEventListener('show-form', event =>{
    //window.open("http://www.desarrolloweb.com" , "ventana1" , "width=1200,height=700,scrollbars=NO")
    window.open(event.detail,this.target,'width=400,height=450,top=120,left=500,toolbar=no,location=no,status=no,menubar=no')
    //$('#form').modal('show');
  });
  window.addEventListener('show-modal-compra', event =>{
      $('#mostrarCompra').modal('show');
  });
</script>
<script>
  Livewire.on('verCompra', Id => {
      //alert('A post was added with the id of: ' + Id);
      $('#mostrarCompra').modal('show');
  })
  </script>
  <script src="{{ asset('vendor/toastr/toastr.min.js')}}"></script>
  <script src="{{ asset('vendor/toastr/sweetalert2@11.js')}}"></script>
  <script>
      Livewire.on( 'confirmar', (id,msj,accion)=>{
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
              if(accion=='1'){
                  Livewire.emitTo('compra.reporte','anularCompra',id);
              }else if(accion=='2'){
                  Livewire.emitTo('compra.reporte','editarCompra',id);
              }
          }
      })
      });
      window.addEventListener('toastr', event =>{
            toastr.success(event.detail.message,'Exito!');
        
        });
        window.addEventListener('toastr-error', event =>{
            toastr.error(event.detail.message,'Error!!!');
        
        });
  </script>
@stop