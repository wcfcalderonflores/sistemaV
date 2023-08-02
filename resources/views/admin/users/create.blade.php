@extends('adminlte::page')
@section('title', 'Crear Usuario')

@section('content_header')
@livewireStyles
    <h1>Crear Usuario <a href="{{url()->previous()}}" ><i class="fa fa-reply fa-sm" style="color: #0f5dab" aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @livewire('admin.reg-user',['tipo'=>'reg','user'=>null,'roles'=>$roles])
@stop
@section('js')
@livewireScripts
@stop