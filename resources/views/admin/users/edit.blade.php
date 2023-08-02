@extends('adminlte::page')
@section('title', 'Edit Usuario')

@section('content_header')
@livewireStyles
    <h1>Editar Usuario <a href="{{url()->previous()}}" ><i class="fa fa-reply fa-sm" style="color: #0f5dab" aria-hidden="true"></i></a></h1>
@stop

@section('content')
    @livewire('admin.reg-user',['tipo'=>'up','user'=>$user,'roles'=>$roles])
@stop
@section('js')
@livewireScripts
@stop
