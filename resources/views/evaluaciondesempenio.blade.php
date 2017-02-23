@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Evaluacion de Desempeño</center></h3>@stop
@section('content')
@include('alerts.request')

{!!Html::script('js/evaluaciondesempenio.js')!!}

@if(isset($evaluaciondesempenio))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($evaluaciondesempenio,['route'=>['evaluaciondesempenio.destroy',$evaluaciondesempenio->idEvaluacionDesempenio],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($evaluaciondesempenio,['route'=>['evaluaciondesempenio.update',$evaluaciondesempenio->idEvaluacionDesempenio],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'evaluaciondesempenio.store','method'=>'POST'])!!}
  @endif
<?php $date = Carbon\Carbon::now();?>





<script>
// se crean dos variables para busar los datos y comprarlos con su funcion correspondiente
//educacion  ademas se adicionan los  onchange del campo nuevo calificacion para que se ejecute al mismo tiempo que cuando se ejecuta la funcion
//de llenar educacion,formacion, Habilidad
// Calificar Educacion
var evaluacioneducacion = ['onchange','calificareducacion(this.id);']
// Calificar Formacion
var evaluacionformacion = ['onchange','calificarformacion(this.id);']
// Calificar Habilidad
var evaluacionhabilidad = ['onchange','calificarhabilidad(this.id);']



// ---------------------------------CONSULTAS PARA EDICION DE MULTIREGISTROS 
// se recibe la respuesta de los datos cuando se va a editar 
var evaluacionresponsabilidad = '<?php echo (isset($EvaluacionDesempenioResponsabilidad) ? json_encode($EvaluacionDesempenioResponsabilidad) : "");?>';
evaluacionresponsabilidad = (evaluacionresponsabilidad != '' ? JSON.parse(evaluacionresponsabilidad) : '');
//se recibe el dato de educacion la consulta
var evaluacionEducacion = '<?php echo (isset($EvaluacionDesempenioEducacion) ? json_encode($EvaluacionDesempenioEducacion) : "");?>';
evaluacionEducacion = (evaluacionEducacion != '' ? JSON.parse(evaluacionEducacion) : '');
// Se reciben los datos consultados de FOrmacion
var evaluacionFormacion = '<?php echo (isset($EvaluacionDesempenioFormacion) ? json_encode($EvaluacionDesempenioFormacion) : "");?>';
evaluacionFormacion = (evaluacionFormacion != '' ? JSON.parse(evaluacionFormacion) : '');
// SE reciben los datos de la consulta de Habilidad 
var evaluacionHabilidad = '<?php echo (isset($EvaluacionDesempenioHabilidad) ? json_encode($EvaluacionDesempenioHabilidad) : "");?>';
evaluacionHabilidad = (evaluacionHabilidad != '' ? JSON.parse(evaluacionHabilidad) : '');
// -----------------------------------------------------------------------



//--------------------------------- Enviados desde Controller
// ----------------------Educacion
var idEducacion = '<?php echo isset($idEducacion) ? $idEducacion : "";?>';
var nombreEducacion = '<?php echo isset($nombreEducacion) ? $nombreEducacion : "";?>';

var educacion = [JSON.parse(idEducacion),JSON.parse(nombreEducacion)];
// -----------------------Formacion
var idFormacion = '<?php echo isset($idFormacion) ? $idFormacion : "";?>';
var nombreFormacion = '<?php echo isset($nombreFormacion) ? $nombreFormacion : "";?>';

var formacion = [JSON.parse(idFormacion),JSON.parse(nombreFormacion)];
// ------------------------Habilidad
var idHabilidad = '<?php echo isset($idHabilidad) ? $idHabilidad : "";?>';
var nombreHabilidad = '<?php echo isset($nombreHabilidad) ? $nombreHabilidad : "";?>';

var habilidad = [JSON.parse(idHabilidad),JSON.parse(nombreHabilidad)];
// ------------------------------------





// ------------------------Respuestas Preguntas------------------

var idRespuesta = '<?php echo isset($idRespuesta) ? $idRespuesta : "";?>';
var nombreRespuesta = '<?php echo isset($nombreRespuesta) ? $nombreRespuesta : "";?>';

 var respuesta = [JSON.parse(idRespuesta),JSON.parse(nombreRespuesta)];
// --------------------------
// Respuesta  multiregistro de Responsabilidades 
valorresponsabilidad = Array('0','25','50','75','100');
tituloresponsabilidad = Array ("Nunca","Casi Nunca","A Veces","Casi Siempre","Siempre");
responsabilidadresultado = [valorresponsabilidad,tituloresponsabilidad];
// Respuesta Multiregistro Habilidad propia del Cargo
valorhabilidadprop = Array('0','50','100','110');
tituloprop = Array ("No Cumple","En Proceso","Cumple","Excede");
habildadPropCargoResultado = [valorhabilidadprop,tituloprop];
$(document).ready(function()
{
   //En el momento de editar
      //Consulta si el campo Tercero_idEmpleado esta lleno (>0) y si es así le envía a campo cargo su valor
      if(document.getElementById('Tercero_idTercero').value > 0)
      {
        llenarCargo(document.getElementById('Tercero_idTercero').value); //llama al metodo llenarCargo y llena el campo cargo
      }
    
// ----------------------------------------------------------Multiregistro Primera Pestaña

          // habilidadactitudinal = new Atributos('habilidadactitudinal','habilidadactitudinal_Modulo','habilidadactitudinaldescripcion_');

          // habilidadactitudinal.campoid = 'idEntrevistaCompetencia';  //hermanitas             
          // habilidadactitudinal.campoEliminacion = 'eliminarhabilidadactitudinal';//hermanitas         Cuando se utilice la funcionalidad 
          // habilidadactitudinal.botonEliminacion = false;//hermanitas
          // // despues del punto son las propiedades que se le van adicionar al objeto
          // habilidadactitudinal.campos = ['idEntrevistaCompetencia','CompetenciaPregunta_idCompetenciaPregunta','preguntaCompetenciaPregunta','CompetenciaRespuesta_idCompetenciaRespuesta']; //[arrays ]
          // habilidadactitudinal.altura = '35px;'; 
          //  // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          // habilidadactitudinal.etiqueta = ['input','input','input','select'];
          // habilidadactitudinal.tipo = ['hidden','hidden','text','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          // habilidadactitudinal.estilo = ['','','width: 800px;height:35px;background-color:#EEEEEE;','width: 300px;height:35px;']; 

          // // estas propiedades no son muy usadas PERO SON UTILES
          
          // habilidadactitudinal.clase = ['','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          // habilidadactitudinal.sololectura = [false,false,true,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          // habilidadactitudinal.completar = ['off','off','off','off']; //autocompleta 
          
          // habilidadactitudinal.opciones = ['','','',respuesta]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          // habilidadactitudinal.funciones  = ['','','','']; 

//-------------------------------------------------------------Multiregistro Segunda Opcion 


          EvaluacionResponsabilidad = new Atributos('EvaluacionResponsabilidad','responsabilidades_Modulo','responsailidadesdescripcion_');

          EvaluacionResponsabilidad.campoid = 'idEvaluacionResponsabilidad';  //hermanitas             
          EvaluacionResponsabilidad.campoEliminacion = 'eliminarresponsabilidades';//hermanitas         Cuando se utilice la funcionalidad 
          EvaluacionResponsabilidad.botonEliminacion = false;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EvaluacionResponsabilidad.campos = ['idEvaluacionResponsabilidad','EvaluacionDesempenio_idEvaluacionDesempenio','descripcionCargoResponsabilidad','CargoResponsabilidad_idCargoResponsabilidad','respuestaEvaluacionResponsabilidad']; //[arrays ]
          EvaluacionResponsabilidad.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EvaluacionResponsabilidad.etiqueta = ['input','input','input','input','select'];
          EvaluacionResponsabilidad.tipo = ['hidden','hidden','text','hidden','']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EvaluacionResponsabilidad.estilo = ['','','width: 800px;height:35px;background-color:#EEEEEE;','','width: 300px;height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EvaluacionResponsabilidad.clase = ['','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EvaluacionResponsabilidad.sololectura = [false,false,true,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EvaluacionResponsabilidad.completar = ['off','off','off','off','off']; //autocompleta 
          
          EvaluacionResponsabilidad.opciones = ['','','','',responsabilidadresultado]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EvaluacionResponsabilidad.funciones  = ['','','','','']; 

  // --------------------------------------------Multiregistro Tercera Opción
          
          EvaluacionEducacion = new Atributos('EvaluacionEducacion','EvaluacionEducacion_Modulo','EvaluacionEducaciondescripcion_');

          EvaluacionEducacion.campoid = 'idEvaluacionEducacion';  //hermanitas             
          EvaluacionEducacion.campoEliminacion = 'eliminarEvaluacionEducacion';//hermanitas         Cuando se utilice la funcionalidad 
          EvaluacionEducacion.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EvaluacionEducacion.campos = ['idEvaluacionEducacion','EvaluacionDesempenio_idEvaluacionDesempenio','nombrePerfilCargo','PerfilCargo_idRequerido_Educacion','porcentajeCargoEducacion','PerfilCargo_idAspirante_Educacion','calificacionEvaluacionEducacion']; //[arrays ]
          EvaluacionEducacion.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EvaluacionEducacion.etiqueta = ['input','input','input','input','input','select','select'];
          EvaluacionEducacion.tipo = ['hidden','hidden','text','hidden','text','','']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EvaluacionEducacion.estilo = ['','','width:260px; height:35px; background-color:#EEEEEE;','','width:100px; height:35px;background-color:#EEEEEE;','width:300px; height:35px;','width:300px; height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EvaluacionEducacion.clase = ['','','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EvaluacionEducacion.sololectura = [false,false,true,false,true,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EvaluacionEducacion.completar = ['off','off','off','off','off','off','off']; //autocompleta 
          
          EvaluacionEducacion.opciones = ['','','','','',educacion,habildadPropCargoResultado]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EvaluacionEducacion.funciones  = ['','','','','',evaluacioneducacion,''];

// ---------------------------------------------------------MultiRegistro 3 opcion acordeon formacion 
          EvaluacionFormacion = new Atributos('EvaluacionFormacion','EvaluacionFormacion_Modulo','EvaluacionFormaciondescripcion_');

          EvaluacionFormacion.campoid = 'idEvaluacionFormacion';  //hermanitas             
          EvaluacionFormacion.campoEliminacion = 'eliminarEvaluacionFormacion';//hermanitas         Cuando se utilice la funcionalidad 
          EvaluacionFormacion.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EvaluacionFormacion.campos = ['idEvaluacionFormacion','EvaluacionDesempenio_idEvaluacionDesempenio','nombrePerfilCargo','PerfilCargo_idRequerido_Formacion','porcentajeCargoFormacion','PerfilCargo_idAspirante_Formacion','calificacionEvaluacionFormacion']; //[arrays ]
          EvaluacionFormacion.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EvaluacionFormacion.etiqueta = ['input','input','input','input','input','select','select'];
          EvaluacionFormacion.tipo = ['hidden','hidden','text','hidden','text','','']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EvaluacionFormacion.estilo = ['','','width:260px; height:35px; background-color:#EEEEEE;','','width:100px; height:35px;background-color:#EEEEEE;','width:300px; height:35px;','width:300px; height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EvaluacionFormacion.clase = ['','','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EvaluacionFormacion.sololectura = [false,false,true,false,true,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EvaluacionFormacion.completar = ['off','off','off','off','off','off','off']; //autocompleta 
          
          EvaluacionFormacion.opciones = ['','','','','',formacion,habildadPropCargoResultado]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EvaluacionFormacion.funciones  = ['','','','','',evaluacionformacion,''];

          // ---------------------------------------------------------MultiRegistro 3 opcion acordeon Habilidad 
          EvaluacionHabilidad = new Atributos('EvaluacionHabilidad','EvaluacionHabilidad_Modulo','EvaluacionHabilidaddescripcion_');

          EvaluacionHabilidad.campoid = 'idEvaluacionHabilidad';  //hermanitas             
          EvaluacionHabilidad.campoEliminacion = 'eliminarEvaluacionHabilidad';//hermanitas         Cuando se utilice la funcionalidad 
          EvaluacionHabilidad.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EvaluacionHabilidad.campos = ['idEvaluacionHabilidad','EvaluacionDesempenio_idEvaluacionDesempenio','nombrePerfilCargo','PerfilCargo_idRequerido_Habilidad','porcentajeCargoHabilidad','PerfilCargo_idAspirante_Habilidad','calificacionEvaluacionHabilidad']; //[arrays ]
          EvaluacionHabilidad.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EvaluacionHabilidad.etiqueta = ['input','input','input','input','input','select','select'];
          EvaluacionHabilidad.tipo = ['hidden','hidden','text','hidden','text','','']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EvaluacionHabilidad.estilo = ['','','width:260px; height:35px; background-color:#EEEEEE;','','width:100px; height:35px;background-color:#EEEEEE;','width:300px; height:35px;','width:300px; height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EvaluacionHabilidad.clase = ['','','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EvaluacionHabilidad.sololectura = [false,false,true,false,true,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EvaluacionHabilidad.completar = ['off','off','off','off','off','off','off']; //autocompleta 
          
          EvaluacionHabilidad.opciones = ['','','','','',habilidad,habildadPropCargoResultado]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EvaluacionHabilidad.funciones  = ['','','','','',evaluacionhabilidad,''];
          
  //------------------------------- For para cuando se este editando 
        
           for(var j=0, k = evaluacionresponsabilidad.length; j < k; j++)
             {
                     EvaluacionResponsabilidad.agregarCampos(JSON.stringify(evaluacionresponsabilidad[j]),'L');              
             } 

             // Edicion Multiregistro Educacion
              for(var j=0, k = evaluacionEducacion.length; j < k; j++)
             {
                     EvaluacionEducacion.agregarCampos(JSON.stringify(evaluacionEducacion[j]),'L');              
             } 

             // Edicion Multiregistro  Formacion
              for(var j=0, k = evaluacionFormacion.length; j < k; j++)
             {
                     EvaluacionFormacion.agregarCampos(JSON.stringify(evaluacionFormacion[j]),'L');              
             } 

             // Edicion Multiregistro Habilidad
              for(var j=0, k = evaluacionHabilidad.length; j < k; j++)
             {
                     EvaluacionHabilidad.agregarCampos(JSON.stringify(evaluacionHabilidad[j]),'L');              
             } 

 });
   

</script> 
<div id='form-section' >

  <fieldset id="evaluaciondesempenio-form-fieldset">  
                 <!-- Tipo de la educacion --> 
                  <div class="form-group" id='test'>
                             {!!Form::label('Tercero_idEmpleado', 'Empleado', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group" style="padding-left:10px "> 
                                  <span class="input-group-addon">
                                    <i class="fa fa-bars" style="width: 14px;"></i> 
                                  </span>
                                     {!!Form::select('Tercero_idEmpleado',$Tercero_idEmpleado, (isset($evaluaciondesempenio) ? $evaluaciondesempenio->Tercero_idEmpleado : 0),["class" => "select form-control", "placeholder" =>"Seleccione",'onchange'=>"llenarCargo(this.value)"])!!}
                                <!-- ID Oculto Formulario  -->
                             {!!Form::hidden('idEvaluacionDesempenio', null, array('id' => 'idEvaluacionDesempenio')) !!}
                                  <!-- id Oculto habiliad actitudinal -->
                            {!!Form::hidden('eliminarhabilidadactitudinal',null, array('id' => 'eliminarhabilidadactitudinal'))!!}
                            <!-- id Oculto  eliminarresponsailidades -->
                            {!!Form::hidden('eliminarresponsabilidades',null, array('id' => 'eliminarresponsabilidades'))!!}
                            <!-- Id Oculto eliminar evaluacion  -->
                            {!!Form::hidden('eliminarEvaluacionEducacion',null, array('id' => 'eliminarEvaluacionEducacion'))!!}
                            <!-- id Oculto eliminar formacion -->
                            {!!Form::hidden('eliminarEvaluacionFormacion',null, array('id' => 'eliminarEvaluacionFormacion'))!!}
                            <!-- id Oculto eliminar Habilidad -->
                            {!!Form::hidden('eliminarEvaluacionHabilidad',null, array('id' => 'eliminarEvaluacionHabilidad'))!!}

                                 
                                 
                            </div>
                        </div>
                  </div>
                     <!--  Cargo -->
                  <div class="form-group" id='test'>
                                {!!Form::label('nombreCargo', 'Cargo ', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group" style="padding-left:10px "> 
                                  <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                  </span>
                          
                           {!! Form::text('nombreCargo',null, ['readonly' => 'readonly', 'class'=>'form-control', 'id'=>'nombreCargo','placeholder'=>'Cargo del empleado']) !!}
                           <!-- se llama el idCargo para poner el nombre cuando se selecciona el empleado -->
                                   {!!Form::hidden('Cargo_idCargo',null, array('id' => 'Cargo_idCargo')) !!}
                            </div>
                       </div>
                  </div>  
                  <!-- Responsable --> 
                  <div class="form-group" id='test'>
                             {!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group" style="padding-left:10px"> 
                                  <span class="input-group-addon">
                                    <i class="fa fa-bars" style="width: 14px;"></i> 
                                  </span>
                                    {!!Form::select('Tercero_idResponsable',$Tercero_idResponsable, (isset($evaluaciondesempenio) ? $evaluaciondesempenio->Tercero_idResponsable : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!} 
                            </div>
                        </div>
                  </div>
                      <!-- Fecha con hora sugerida por ele sistema  --> 
                  <div class="form-group" id='test'>
                             {!!Form::label('fechaElaboracionEvaluacionDesempenio', 'Fecha', array('class' => 'col-sm-1 control-label')) !!}
                        <div class="col-sm-11">
                            <div class="input-group" style="padding-left:10px "> 
                                  <span class="input-group-addon">
                                    <i class="fa fa-calendar" style="width: 14px;"></i> 
                                  </span>
                                
                                    {!!Form::text('fechaElaboracionEvaluacionDesempenio',(isset($evaluaciondesempenio) ? $evaluaciondesempenio->fechaElaboracionEvaluacionDesempenio : date('Y-m-d-hh:mm:ss')),['class'=>'form-control','placeholder'=>'Ingresa la fecha creaci&oacute;n '])!!}


                                  
                                 
                            </div>
                        </div>
                  </div>

  </fieldset>                                          
</div>
<br>
<br>

 <input type="hidden" id="token" value="{{csrf_token()}}"/>
                                              <!-- OPCIONES DEL FORMULARIO  -->  

                                        
                            <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab"  onclick="mostrarDivGenerales('Habilidadesactitudinales')" href="#Habilidadesactitudinales">Habilidades Actitudinales</a></li> <!-- Se hizo un cambio para evitar cambiar la funciones de los divs nada mas se le cambia el nombre a competencia y Generales -->
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Responsabilidades')" href="#Responsabilidades">Responsabilidades</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Habilidades')" href="#Habilidades">Habilidades propias del Cargo</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Resultado')" href="#Resultado">Resultado</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('planaccion')" href="#planaccion">Plan Accion</a></li>

                              </ul>

                              <div class="tab-content">
                                    <div id="Habilidadesactitudinales" class="tab-panel fade in active" >
                                 <!--  HTML Multiregistro  Habilidades sin Boton de Agregar solo con Ajax  -->                                    
                                        <div class="form-group" id='test'>
                                              <div class="col-sm-12">
                                                  <div class="row show-grid">
                                                      <div class="col-md-1" style="width: 800px;display:inline-block;height:35px;">Pregunta </div>
                                                      <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Respuesta</div>
                                                    
                                                      <!-- este es el div para donde van insertando los registros --> 
                                                      <div id="habilidadactitudinal_Modulo">
                                                      </div>
                                                  </div>
                                              </div>      
                                        </div> 
                                    </div>

                                    <!-- OPCION 2 -->
                                    <div id="Responsabilidades" class="tab-pane fade">
                                      <!-- Label % Peso -->
                                       <div class="form-group" id='test' >
                                          {!!Form::label('PesoPorcentajeResponsabilidad', '% Peso', array('class' => 'col-sm-1 control-label'))!!}
                                            <div class="col-sm-10">
                                              <div class="input-group" style="padding-left:10px ">
                                                <span class="input-group-addon">
                                                  <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                </span>
                                                {!!Form::text('PesoPorcentajeResponsabilidad',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                              </div>
                                            </div>
                                      </div> 
                                      <!--  HTML Multiregistro  Responsabilidad sin Boton de Agregar solo con Ajax  -->                      <!-- nuevo campo para Calificacion  -->                      
                                        <div class="form-group" id='test'>
                                              <div class="col-sm-12">
                                                  <div class="row show-grid">
                                                      <div class="col-md-1" style="width: 800px;display:inline-block;height:35px;">Responsabilidad</div>
                                                      <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Respuesta</div>
                                                    
                                                      <!-- este es el div para donde van insertando los registros --> 
                                                      <div id="responsabilidades_Modulo">
                                                      </div>
                                                  </div>
                                              </div>      
                                        </div> 
                                    </div>   
                                    
                                    </div>
                                                                  
                                    <!-- OPCION 3 -->
                                   <div style="display:none;" id="Habilidades" class="tab-pane fade">
                                                    
                                     <div class="form-group">
                                            <div class="panel panel-default">
                                                  <!-- <div class="panel-heading">General</div> -->
                                                <div class="panel-body">
                                                    <div class="panel-group"  id="accordion">
                                                              <!-- Educacion -->
                                                          <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h4 class="panel-title">
                                                                  <a data-toggle="collapse" data-parent="#accordion"  href="#Educacion">Educacion</a>
                                                                </h4>
                                                            </div>
                                                            <div  id="Educacion" class="panel-collapse collapse">
                                                              <div class="panel-body">
                                                                   <div class="form-group" id='test' >
                                                                            {!!Form::label('PesoPorcentajeEducacion', '%Peso', array('class' => 'col-sm-1 control-label'))!!}
                                                                          <div class="col-sm-10">
                                                                              <div class="input-group" style="padding-left:10px ">
                                                                                  <span class="input-group-addon">
                                                                                    <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                  </span>
                                                                                  <!-- Se pone la ruta en el campo null para que esta traiga el porcentaje al momento de Editar -->
                                                                                  {!!Form::text('PesoPorcentajeEducacion',(isset($evaluaciondesempenio->Cargo->porcentajeEducacionCargo) ? $evaluaciondesempenio->Cargo->porcentajeEducacionCargo: null),['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                              </div>
                                                                          </div>
                                                                    </div>
                                                                                  <!-- Detalle Educacion  -->
                                                                    <div class="form-group" id='test'>
                                                                        <div class="col-sm-12">

                                                                          <div class="row show-grid">
                                                                            
                                                                              <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                             <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                             <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>

                                                                             <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Resultado</div>

                                                                            
                                                                              <!-- este es el div para donde van insertando los registros --> 
                                                                              <div id="EvaluacionEducacion_Modulo">
                                                                              </div>

                                                                          </div>
                                                                                              
                                                                      
                                                                        </div>
                                                                      </div> 
                                                              </div>
                                          
                                                            </div>

                                                          </div>  
                                                                            <!-- FORMACION -->
                                                      <div  class="panel panel-default">
                                                            <div class="panel-heading">
                                                              <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#Formacion">Formacion</a>
                                                              </h4>
                                                            </div>
                                                                <div id="Formacion" class="panel-collapse collapse">  
                                                                      <div class="panel-body">
                                                                       <div class="form-group" id='test' >
                                                                            {!!Form::label('PesoPorcentajeFormacion', '%Peso', array('class' => 'col-sm-1 control-label'))!!}
                                                                            <div class="col-sm-10">
                                                                                <div class="input-group" style="padding-left:10px ">
                                                                                    <span class="input-group-addon">
                                                                                      <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                    </span>
                                                                                    {!!Form::text('PesoPorcentajeFormacion',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                                 <!-- Detalle Formacion  -->
                                                                            <div class="form-group" id='test'>
                                                                                <div class="col-sm-12">

                                                                                  <div class="row show-grid">
                                                                                    <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                                   <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                                   <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>
                                                                                  <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Resultado</div>
                                                                                  
                                                                                    <!-- este es el div para donde van insertando los registros --> 
                                                                                    <div id="EvaluacionFormacion_Modulo">
                                                                                    </div>
                                                                                  </div>
                                                                                      
                                                                                </div>
                                                                              </div> 
                                                                            </div>
                                                                   </div>
                                                        </div>  
                                                                                <!-- habilidades -->
                                                      <div  class="panel panel-default">
                                                            <div class="panel-heading">
                                                              <h4 class="panel-title">
                                                                <a data-toggle="collapse" data-parent="#accordion" href="#Habilidadesinterno">Habilidades propias del Cargo</a>
                                                              </h4>
                                                            </div>
                                                                <div id="Habilidadesinterno" class="panel-collapse collapse">  
                                                                      <div class="panel-body">
                                                                           <div class="form-group" id='test' >
                                                                                {!!Form::label('PesoPorcentajeHabilidad', '%Peso', array('class' => 'col-sm-1 control-label'))!!}
                                                                                <div class="col-sm-10">
                                                                                    <div class="input-group" style="padding-left:10px ">
                                                                                        <span class="input-group-addon">
                                                                                          <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                        </span>
                                                                                        {!!Form::text('PesoPorcentajeHabilidad',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                                 <!-- Detalle habilidad  -->
                                                                            <div class="form-group" id='test'>
                                                                                <div class="col-sm-12">

                                                                                  <div class="row show-grid">
                                                                                    <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                                   <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                                   <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>
                                                                                  <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Resultado</div>
                                                                                  
                                                                                    <!-- este es el div para donde van insertando los registros --> 
                                                                                    <div id="EvaluacionHabilidad_Modulo">
                                                                                    </div>
                                                                                  </div>
                                                                                            
                                                                                </div>
                                                                              </div> 
                                                                      </div>
                                                                  </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                      </div>
                                  </div>

                                                 <!--  OOPCION 4 -->
                                   <div id="Resultado" class="tab-pane fade">
                                    RESULTADO
                                    </div>
                                              <!--  OOPCION 4 -->
                                   <div id="planaccion" class="tab-pane fade">
                                    plan accion
                                    </div>

                              </div>
@if(isset($evaluaciondesempenio))
   @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
    @else
      {!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
    @endif
@else
    {!!Form::submit('Guardar',["class"=>"btn btn-primary"])!!}
@endif
  <!-- ,"onclick"=>'validarFormulario(event);' -->

 {!! Form::close() !!}
        


<script type="text/javascript">
  

    $('#fechaElaboracionEvaluacionDesempenio').datetimepicker({
      format: "YYYY-MM-DD HH:mm:ss"
    });

</script>
   
   @stop
