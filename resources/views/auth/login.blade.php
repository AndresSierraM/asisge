@extends('layouts.acceso')

@section('content')
@include('alerts.errors')




        
        <div id="contenedor">
            {!! Form::open(['route' => 'auth/login', 'class' => 'form'])!!}
            {{-- Preguntamos si hay algún mensaje de error y si hay lo mostramos  --}}
        @if(Session::has('mensaje_error'))
            {{ Session::get('mensaje_error') }}
        @endif
        
                {!!Form::email('email','',['class'=> 'form-control','id'=>'nombre'])!!}
                
                <div class= "caja">
                    {!!Form::select('Compania_idCompania',$compania, 0,["placeholder" =>"Seleccione la Compañía"])!!}
                </div>
                    {!!Form::password('password', ['class'=> 'form-control','id'=>'password'])!!}
               
                <input type="checkbox" name="recordarme" id="recordarme">
                <label for="recordarme"></label>
                <p id="tex-recordarme">Recordame</p>
                {!! Form::submit('',['id' => 'enviar']) !!}
            {!!Form::close()!!}
        </div>
       



@stop