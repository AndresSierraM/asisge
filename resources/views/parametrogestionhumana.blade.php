@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Parametros GestionHumana</center></h3>@stop
@section('content')
@include('alerts.request')
<!-- {!!Html::script('js/competencia.js')!!} -->


@if(isset($parametrogestionhumana))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($parametrogestionhumana,['route'=>['parametrogestionhumana.destroy',$competenciarango->idCompetenciaRango],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($parametrogestionhumana,['route'=>['parametrogestionhumana.update',$competenciarango->idCompetenciaRango],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'parametrogestionhumana.store','method'=>'POST'])!!}
  @endif






<script>
// Se reciben los datos enviados desde la consulta en el controller 
 var CompetenciaRespuestaH = '<?php echo (isset($CompetenciaRespuesta) ? json_encode($CompetenciaRespuesta) : "");?>';
CompetenciaRespuestaH = (CompetenciaRespuestaH != '' ? JSON.parse(CompetenciaRespuestaH) : '');

var CompetenciaRangoH = '<?php echo (isset($CompetenciaRango) ? json_encode($CompetenciaRango) : "");?>';
CompetenciaRangoH = (CompetenciaRangoH != '' ? JSON.parse(CompetenciaRangoH) : '');



// ------------------------------------------------------------------

var competenciaRespuesta = [0,'','',''];
  var competenciaRango = [0,0,'','',''];
  $(document).ready(function(){

// Multiiregistro primera Opcion
    competenciarespuesta = new Atributos('competenciarespuesta','competenciarespuesta_Modulo','competenciarespuestadescripcion');

    competenciarespuesta.campoid = 'idCompetenciaRespuesta';  //hermanitas             
    competenciarespuesta.campoEliminacion = 'eliminarcompetenciarespuesta';//hermanitas         Cuando se utilice la funcionalidad 
    competenciarespuesta.botonEliminacion = true;//hermanitas
    // despues del punto son las propiedades que se le van adicionar al objeto
    competenciarespuesta.campos = ['idCompetenciaRespuesta','respuestaCompetenciaRespuesta','porcentajeNormalCompetenciaRespuesta','porcentajeInversoCompetenciaRespuesta']; //[arrays ]
    competenciarespuesta.altura = '35px;';  
     // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
    competenciarespuesta.etiqueta = ['input','textarea','input','input'];
    competenciarespuesta.tipo = ['hidden','textarea','text','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
    competenciarespuesta.estilo = ['','vertical-align:top; width: 400px;  height:35px;','width: 300px;height:35px;','width: 300px;height:35px;'];  

    // estas propiedades no son muy usadas PERO SON UTILES
    
    competenciarespuesta.clase = ['','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
    competenciarespuesta.sololectura = [false,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
    competenciarespuesta.completar = ['off','off','off','off']; //autocompleta 
    competenciarespuesta.opciones = ['','','','']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
    competenciarespuesta.funciones  = ['','','','']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  

    // ------------------------------------------------------------------------------

    // MUltiregistro segunda opcion Rango porcentajes

    //objeto  ---  instancia  ---     PARAMETROS  
    competenciarango = new Atributos('competenciarango','competenciarango_Modulo','competenciarangodescripcion');

    competenciarango.campoid = 'idCompetenciaRango';  //hermanitas             
    competenciarango.campoEliminacion = 'eliminarcompetenciarango';//hermanitas         Cuando se utilice la funcionalidad 
    competenciarango.botonEliminacion = true;//hermanitas
    // despues del punto son las propiedades que se le van adicionar al objeto
    competenciarango.campos = ['idCompetenciaRango','ordenCompetenciaRango','nivelCompetenciaRango','desdeCompetenciaRango','hastaCompetenciaRango']; //[arrays ]
    competenciarango.altura = '35px;';  
     // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
    competenciarango.etiqueta = ['input','input','input','input','input'];
    competenciarango.tipo = ['hidden','text','text','text','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
    competenciarango.estilo = ['','width: 100px;height:35px;','width: 300px;height:35px;','width: 300px;height:35px;','width: 300px;height:35px;'];  

    // estas propiedades no son muy usadas PERO SON UTILES
    
    competenciarango.clase = ['','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
    competenciarango.sololectura = [false,false,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
    competenciarango.completar = ['off','off','off','off','off']; //autocompleta 
    competenciarango.opciones = ['','','','','']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
    competenciarango.funciones  = ['','','','','']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  

// -----------------------------------------------------------------------------------------------------------
      //Llenado de campos de las Multiregistros  
              for(var j=0, k = CompetenciaRespuestaH.length; j < k; j++)
                 {
              
                   competenciarespuesta.agregarCampos(JSON.stringify(CompetenciaRespuestaH[j]),'L');
                 }

                    for(var j=0, k = CompetenciaRangoH.length; j < k; j++)
                 {
              
                   competenciarango.agregarCampos(JSON.stringify(CompetenciaRangoH[j]),'L');
                 }



    
  });
</script> 
                    
<div class="parametrogestionhumana-container">
    <!-- Id Oculto Eliminar Plan Accion -->
    {!!Form::hidden('eliminarcompetenciarango',null, array('id' => 'eliminarcompetenciarango'))!!}
     <!-- Id Oculto Eliminar Plan Accion -->
    {!!Form::hidden('eliminarcompetenciarespuesta',null, array('id' => 'eliminarcompetenciarespuesta'))!!}


    
      <form class="form-horizontal" action="" method="post">
         <legend class="text-center"></legend>    
<input type="hidden" id="token" value="{{csrf_token()}}"/>
                                        <!-- OPCIONES DEL FORMULARIO  -->  
                                        
                            <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab" onclick="mostrarDivGenerales('Respuesta')"  href="#Respuesta">Respuesta por Porcentaje</a></li> 
                              <li class=""><a data-toggle="tab" onclick="mostrarDivGenerales('Rangos')"  href="#Rangos">Rangos de Porcentajes</a></li>
                           </ul>

                    <div class="tab-content">
                      <div id="Respuesta" class="tab-panel fade in active">
                       <div class="form-group" id='test'>
                                  <div class="col-sm-12">

                                    <div class="row show-grid">
                                        <div class="col-md-1" style="width: 40px;height: 35px;" onclick="competenciarespuesta.agregarCampos(competenciaRespuesta,'A')">
                                          <span class="glyphicon glyphicon-plus"></span>
                                        </div>
                                        <div class="col-md-1" style="width: 400px;display:inline-block;height:35px;">Respuesta</div>
                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Porcentaje Normal</div>
                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Porcentaje Inverso</div>
                                        
                                          

                                        <!-- este es el div para donde van insertando los registros --> 
                                        <div id="competenciarespuesta_Modulo">
                                        </div>
                                    </div>
                                  </div>
                               </div> 
                      </div>
                      <!-- Rango de PPorcentajes   -->
                       <div id="Rangos" class="tab-pane fade">
                               <div class="form-group" id='test'>
                                  <div class="col-sm-12">

                                    <div class="row show-grid">
                                        <div class="col-md-1" style="width: 40px;height: 35px;" onclick="competenciarango.agregarCampos(competenciaRango,'A')">
                                          <span class="glyphicon glyphicon-plus"></span>
                                        </div>
                                        <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">Orden</div>
                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Nivel Puntuacion</div>
                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Desde(%)</div>
                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Hasta(%)</div>
                                          

                                        <!-- este es el div para donde van insertando los registros --> 
                                        <div id="competenciarango_Modulo">
                                        </div>
                                    </div>
                                  </div>
                               </div>  
                        </div>

                   
                     

                    </div>

    
                
                                    </br>


                            @if(isset($parametrogestionhumana))
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
   
<script type="text/javascript">
  function mostrarDivGenerales(id)
 {
 
 
  if (id == 'Respuesta') 
  {
    $("#Respuesta").css('display', 'block');
    $("#Rangos").css('display', 'none');
 
  }


  else if (id == 'Rangos')
  {

    $("#Respuesta").css('display', 'none');
    $("#Rangos").css('display', 'block');
    
  }



 }

</script>
        

                   