@extends('unilogin::master')
 
@if($expired)
  @section('title', 'Session caducada')
@else
  @section('title', 'Éxito')     
@endif

 
@section('content')
  @if($expired)
    <h1>Esta sesión ya fue utilizada. Vuelva a ingresar con Unilogin.</h1>
  @else
    <h1>Hey! Bienvenido, iniciaste sesión con éxito.</h1>
  @endif
@stop
