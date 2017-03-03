@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Parametros GestionHumana</center></h3>@stop
@section('content')
@include('alerts.request')
<!-- {!!Html::script('js/competencia.js')!!} -->


@if(isset($competencia))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($competencia,['route'=>['competencia.destroy',$competencia->idCompetencia],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($competencia,['route'=>['competencia.update',$competencia->idCompetencia],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'competencia.store','method'=>'POST'])!!}
  @endif






<script>



 var competencias = '<?php echo (isset($competencia) ? json_encode($competencia->CompetenciaPregunta) : "");?>';
competencias = (competencias != '' ? JSON.parse(competencias) : '');

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
    competencia.etiqueta = ['input','input','input','input','input','input'];
    competencia.tipo = ['hidden','text','text','text','text','hidden']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
    competencia.estilo = ['','width: 100px;height:35px;','width: 300px;height:35px;','width: 300px;height:35px;','width: 300px;height:35px;',''];  

    // estas propiedades no son muy usadas PERO SON UTILES
    
    competencia.clase = ['','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
    competencia.sololectura = [false,false,false,false,false,true]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
    competencia.completar = ['off','off','off','off','off','off']; //autocompleta 
    competencia.opciones = ['','','',TipoRespuesta,Estado,'']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
    competencia.funciones  = ['','','','','','']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  

       for(var j=0, k = competencias.length; j < k; j++)
         {
      
           competencia.agregarCampos(JSON.stringify(competencias[j]),'L');
         
        }
  });
</script> 
                          
<div class="competencia-container">
      <form class="form-horizontal" action="" method="post">
         <legend class="text-center"></legend>    
<input type="hidden" id="token" value="{{csrf_token()}}"/>
                     <!--  Multiregistro    -->
    
                <div class="form-group" id='test'>
                    <div class="col-sm-12">

                      <div class="row show-grid">
                        <div class="col-md-1" style="width: 40px;height: 35px;" onclick="competencia.agregarCampos(competenciamodelo,'A')">
                          <span class="glyphicon glyphicon-plus"></span>
                        </div>
                        <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">Orden</div>
                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Nivel Puntuacion</div>
                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Desde(%)</div>
                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Hasta(%)</div>
                          

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
                                  {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
                                @endif
                              @else
                                {!!Form::submit('Guardar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
                              @endif

                             {!! Form::close() !!}
                          </div>


                      </div>  


     
       </form>
       
      

</div> 

    
   @stop
   

        

                   