@extends('layouts.acceso')

@section('content')
<center>@include('alerts.logError')</center>


        <div id="contenedor">
            {!! Form::open(['route' => 'auth/login', 'class' => 'form'])!!}
                {!!Form::email('email','',["required"=>"required",'class'=> 'form-control','id'=>'nombre','placeholder'=>'Digite su correo'])!!}
                
                {!!Form::password('password', ["required"=>"required",'class'=> 'form-control','id'=>'password','placeholder' => 'Digite su contraseña'])!!}

                <div class style="top: 130px; left: 145px; position: absolute;width:170px;height:100px;z-index:auto ">
                    {!!Form::select('Compania_idCompania',$compania, 0,['style' => 'width: 170px;height:100px;', "class" => "chosen-select form-control","required"=>"required","placeholder" =>"Seleccione la compañía"])!!}
                </div>
               
                <input type="checkbox" name="recordarme" id="recordarme">
                <label for="recordarme"></label>
                <p id="tex-recordarme">Recuérdame</p>
                {!! Form::submit('',['id' => 'enviar']) !!}
            {!!Form::close()!!}
        </div>
       



@stop