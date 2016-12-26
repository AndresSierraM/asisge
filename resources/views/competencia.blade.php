@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Cuestionario Por Competencia</center></h3>@stop
@section('content')
@include('alerts.request')



@if(isset($competencia))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($competencia,['route'=>['competencia.destroy',$competencia->idcompetencia],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($competencia,['route'=>['competencia.update',$competencia->idcompetencia],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'competencia.store','method'=>'POST'])!!}
  @endif






<script>

// Se Crea Otra Variable para el Tpo de respuesta 
valorRespuesta = Array("Normal","Inversa");
NombreRespuesta = Array ("Normal","Inversa");

TipoRespuesta = [valorRespuesta,NombreRespuesta];



// se crean las dos variables para el select de  Estado
valorEstado = Array("Activo","Inactivo");
NombreEstado = Array ("Activo","Inactivo");

Estado = [valorEstado,NombreEstado];

  var competenciamodelo = [0,0,'','',''];
  $(document).ready(function(){
    //objeto  ---  instancia  ---     PARAMETROS  
    competencia = new Atributos('competencia','competencia_Modulo','competenciadescripcion');

    competencia.campoid = 'idCompetenciaPregunta';  //hermanitas             
    competencia.campoEliminacion = 'idsborrados';//hermanitas         Cuando se utilice la funcionalidad 
    competencia.botonEliminacion = true;//hermanitas
    // despues del punto son las propiedades que se le van adicionar al objeto
    competencia.campos = ['idCompetenciaPregunta ','ordenCompetenciaPregunta','preguntaCompetenciaPregunta','respuestaCompetenciaPregunta','estadoCompetenciaPregunta','Competencia_idCompetencia']; //[arrays ]
    competencia.altura = '35px;';
     // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
    competencia.etiqueta = ['input','input','input','styleect','select','input'];
    competencia.tipo = ['hidden','text','text','','','hidden']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
    competencia.estilo = ['','width: 300px;height:35px;','width: 600px;height:35px;','width: 300px;height:35px;','width: 300px;height:35px;',''];  

    // estas propiedades no son muy usadas PERO SON UTILES
    
    competencia.clase = ['','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
    competencia.sololectura = [false,false,false,false,false,true]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
    competencia.completar = ['off','off','off','off','off','off']; //autocompleta 
    competencia.opciones = ['','','',TipoRespuesta,Estado,'']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
    competencia.funciones  = ['','','','','','']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  
  });
</script> 
                          
<div class="competencia-container">
      <form class="form-horizontal" action="" method="post">
         <legend class="text-center"></legend>    

                      <!-- Competencia --> 
                  <div class="form-group" id='test'>
                             {!!Form::label('nombreCompetencia', 'Competencia', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group"> 
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square-o"></i> 
                                  </span>
                           {!!Form::text('nombreCompetencia',null,['class'=>'form-control','placeholder'=>'Por favor ingrese su Nombre','style'=>'width:100%;,right'])!!}
                              {!!Form::hidden('idCompetencia', null, array('id' => 'idCompetencia')) !!}
                                 
                            </div>
                        </div>
                    </div>
                                   <!--   Estado de la Competencia  -->

                    <div class="form-group" id='test'>
                                {!!Form::label('estadoCompetencia', 'Estado ', array('class' => 'col-sm-1 control-label')) !!}
                          <div class="col-sm-11">
                            <div class="input-group"> 
                                  <span class="input-group-addon">
                                  <i class="fa fa-bars"></i>
                                  </span>
                         {!! Form::select('estadoCompetencia', ['Activo' =>'Activo','Inactivo' => 'Inactivo'],null,['class' => 'form-control']) !!}
                                                                  
                        </div>
                       </div>
                    </div>

                     <!--  HTML Multiregistro   -->
    
                <div class="form-group" id='test'>
                    <div class="col-sm-12">

                      <div class="row show-grid">
                        <div class="col-md-1" style="width: 40px;height: 35px;" onclick="competencia.agregarCampos(competenciamodelo,'A')">
                          <span class="glyphicon glyphicon-plus"></span>
                        </div>
                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Orden</div>
                        <div class="col-md-1" style="width: 600px;display:inline-block;height:35px;">Pregunta</div>
                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Tipo Respuesta</div>
                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Estado</div>
                          

                        <!-- este es el div para donde van insertando los registros --> 
                        <div id="competencia_Modulo">
                        </div>
                      </div>
                    </div>
                </div>  
                                    </br>


                            @if(isset($competencia))
                               @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
                                  {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
                                @else
                                  {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
                                @endif
                              @else
                                {!!Form::submit('Guardar',["class"=>"btn btn-primary"])!!}
                              @endif

                             {!! Form::close() !!}
                          </div>


                      </div>  


     
       </form>
       
      

</div> 

    
   @stop
   

        

                   