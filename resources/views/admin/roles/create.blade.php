@extends('adminlte::page')
@section('title', 'Rol')

@section('content_header')

    <h1>Crear nuevo rol <a href="{{url()->previous()}}" ><i class="fa fa-reply fa-sm" style="color: #0f5dab" aria-hidden="true"></i></a></h1>
@stop

@section('content')
@if (session('info'))
    
    <div class="alert alert-success">
        <strong>{{session('info')}}</strong>
    </div>
@endif
    @livewire('admin.reg-role',['tipo'=>'create'])
@stop
