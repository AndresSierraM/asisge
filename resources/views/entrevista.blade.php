@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Entrevistas</center></h3>@stop
@section('content')
@include('alerts.request')

{!!Html::script('js/entrevista.js')!!}

@if(isset($entrevista))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($entrevista,['route'=>['entrevista.destroy',$entrevista->idEntrevista],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($entrevista,['route'=>['entrevista.update',$entrevista->idEntrevista],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'entrevista.store','method'=>'POST'])!!}
  @endif



<?php 
// if(isset($encuestae))
// {
//   // convertimos la consulta en array por facilidad de manejo
//   $datos = array();

//   for($i = 0; $i < count($encuestae); $i++)
//   {
//       $datos[] = get_object_vars($encuestae[$i]); 
//   }




  // print_r($encuestae);  // este debe imprimir como llega original desde el controlador
  //  print_r($datos); // este es el array ya convertido

   
//   $textohtml =  '<div class="PublicacionForm">
//      <center><label class="PublicacionTitulo">'.$datos[0]["tituloEncuesta"].'</label></center>
//      <label class="PublicacionSubtitulo">'.$datos[0]["descripcionEncuesta"].'</label>';

//   $i = 0;
//   $numPreg = 0;
//   while($i < count($datos))
//   {

//    // Imprime la Pregunta y la descripcion de la pregunta
//    $textohtml .=  '<div class="divEncuesta">
//      <div class="PublicacionPregunta">'.($numPreg+1).') '.$datos[$i]["preguntaEncuestaPregunta"].'</div> 
//      <div class="PublicacionDetalle">
//       '.$datos[$i]["detalleEncuestaPregunta"].'
//      </div>';

//      // imprime la respuesta (no editable)
//    $textohtml .=  '<div class="PublicacionSelect">'.
//      $datos[$i]["valorEntrevistaEncuestaRespuesta"].'
//     </div>
//     </div>';
//     $i++;
//    $numPreg++;
//   }



//   $textohtml .=  '
//     </div>
//     </div>';
// }

?>



<script>
 var parentesco = '<?php echo (isset($entrevista) ? json_encode($entrevista->EntrevistaHijo) : "");?>';
    parentesco = (parentesco != '' ? JSON.parse(parentesco) : '');

 var relacion = '<?php echo (isset($entrevista) ? json_encode($entrevista->EntrevistaRelacionFamiliar) : "");?>';
relacion = (relacion != '' ? JSON.parse(relacion) : '');

//se llama la consulta (entrevistacompetencia) que se hace en el controlador para llenar la multiregistro cuando se este editando
 var entrevistacompetenciap = '<?php echo (isset($entrevistacompetencia) ? json_encode($entrevistacompetencia) : "");?>';
entrevistacompetenciap = (entrevistacompetenciap != '' ? JSON.parse(entrevistacompetenciap) : '');


 var entrevistaeducacion = '<?php echo (isset($EntrevistaEducacion) ? json_encode($EntrevistaEducacion) : "");?>';
entrevistaeducacion = (entrevistaeducacion != '' ? JSON.parse(entrevistaeducacion) : '');


 var entrevistaformacion = '<?php echo (isset($EntrevistaFormacion) ? json_encode($EntrevistaFormacion) : "");?>';
entrevistaformacion = (entrevistaformacion != '' ? JSON.parse(entrevistaformacion) : '');

 var entrevistahabilidades = '<?php echo (isset($EntrevistaHabilidad) ? json_encode($EntrevistaHabilidad) : "");?>';
entrevistahabilidades = (entrevistahabilidades != '' ? JSON.parse(entrevistahabilidades) : '');


 //  var encuestae = '<?php echo (isset($encuestae) ? json_encode($encuestae) : "");?>';
 // encuestae = (encuestae != '' ? JSON.parse(encuestae) : '');


var idEducacion = '<?php echo isset($idEducacion) ? $idEducacion : "";?>';
var nombreEducacion = '<?php echo isset($nombreEducacion) ? $nombreEducacion : "";?>';

var idFormacion = '<?php echo isset($idFormacion) ? $idFormacion : "";?>';
var nombreFormacion = '<?php echo isset($nombreFormacion) ? $nombreFormacion : "";?>';

var idHabilidad = '<?php echo isset($idHabilidad) ? $idHabilidad : "";?>';
var nombreHabilidad = '<?php echo isset($nombreHabilidad) ? $nombreHabilidad : "";?>';

var idRespuesta = '<?php echo isset($idRespuesta) ? $idRespuesta : "";?>';
var nombreRespuesta = '<?php echo isset($nombreRespuesta) ? $nombreRespuesta : "";?>';



var educacion = [JSON.parse(idEducacion),JSON.parse(nombreEducacion)];
var formacion = [JSON.parse(idFormacion),JSON.parse(nombreFormacion)];
var habilidad = [JSON.parse(idHabilidad),JSON.parse(nombreHabilidad)];
var respuesta = [JSON.parse(idRespuesta),JSON.parse(nombreRespuesta)];




valorParentesco = Array("Padre","Madre","Hermanos","Conyugue","Hijos");
NombreParentesco = Array ("Padre","Madre","Hermanos","Conyugue","Hijos");
ParentescoFamiliar = [valorParentesco,NombreParentesco];


valorrelacion = Array("Distante","Normal","Amistosa","NoExiste");
Nombrerelacion = Array ("Distante","Normal","Amistosa","NoExiste");
Relacionfamiliar = [valorrelacion,Nombrerelacion];



valorCumple = Array('5','4','3','2','1');
NombreCumple = Array ("Total","Parcial Avanzado","Parcial Intermedio","Parcial Introductor","No Cumple");
Cumplimiento = [valorCumple,NombreCumple];
var Relacionfamilia = [0,0,'','']
var competenciamodelo = [0,0,'','',''];

// se crean dos variables para busar los datos y comprarlos con su funcion correspondiente
//educacion  ademas se adicionan los  onchange del campo nuevo calificacion para que se ejecute al mismo tiempo que cuando se ejecuta la funcion
//de llenar educacion,formacion, Habilidad
var evaluacioneducacion = ['onchange','calificareducacion(this.id);calificacionEduacionEntrevista(this.value);']
//variable para formacion 
var evaluacionformacion = ['onchange','calificarformacion(this.id);calificacionFormacionEntrevistas(this.value);']
                                                                   
// Habilidad
 var evaluacionhabilidad = ['onchange','calificarHabilidad(this.id);calificacionHabilidadEntrevista(this.value);']

//Competencia
// Habilidad
  // var evaluacionCompetencia = ['onchange','calificacionHabilidadActitudinal(this.id)']
 
//VARIABLES
 $(document).ready( function () {
// // multiregistro Educacion Entrevista primera Multiregistro OPCION GENERAL          
          Educacionentrevista = new Atributos('Educacionentrevista','EducacionEntrevista_Modulo','Educaciondescripcion_');

          Educacionentrevista.campoid = 'idEntrevistaEducacion';  //hermanitas             
          Educacionentrevista.campoEliminacion = 'eliminarEducacionEntrevista';//hermanitas         Cuando se utilice la funcionalidad 
          Educacionentrevista.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          Educacionentrevista.campos = ['idEntrevistaEducacion','nombrePerfilCargo','PerfilCargo_idRequerido_Educacion','porcentajeCargoEducacion','PerfilCargo_idAspirante_Educacion','calificacionEntrevistaEducacion','Entrevista_idEntrevista']; //[arrays ]
          Educacionentrevista.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          Educacionentrevista.etiqueta = ['input','input','input','input','select','select','input'];
          Educacionentrevista.tipo = ['hidden','text','hidden','text','hidden','','hidden']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          Educacionentrevista.estilo = ['', 'width:260px; height:35px; background-color:#EEEEEE;', '', 'width:100px; height:35px;background-color:#EEEEEE;', 'width:300px; height:35px; ', 'width:300px; height:35px;' ,'']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          Educacionentrevista.clase = ['','','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          Educacionentrevista.sololectura = [false,true,false,true,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          Educacionentrevista.completar = ['off','off','off','off','off','off','off']; //autocompleta 
          
          Educacionentrevista.opciones = ['','','','',educacion,Cumplimiento,'']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          Educacionentrevista.funciones  = ['','','','',evaluacioneducacion,'',''];

// // multiregistro Formacionentrevista Segunda multiregistro OPCION GENERAL
       
          Formacionentrevista = new Atributos('Formacionentrevista','FormacionEntrevista_Modulo','Formacionentrevistaciondescripcion_');

          Formacionentrevista.campoid = 'idEntrevistaFormacion';  //hermanitas             
          Formacionentrevista.campoEliminacion = 'eliminarFormacionEntrevista';//hermanitas         Cuando se utilice la funcionalidad 
          Formacionentrevista.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          Formacionentrevista.campos = ['idEntrevistaFormacion','nombrePerfilCargo','PerfilCargo_idRequerido_Formacion','porcentajeCargoFormacion','PerfilCargo_idAspirante_Formacion','calificacionEntrevistaFormacion','Entrevista_idEntrevista']; //[arrays ]
          Formacionentrevista.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          Formacionentrevista.etiqueta = ['input','input','input','input','select','select','input'];
          Formacionentrevista.tipo = ['hidden','text','hidden','text','hidden','','hidden']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          Formacionentrevista.estilo = ['', 'width:260px; height:35px; background-color:#EEEEEE;', '', 'width:100px; height:35px;background-color:#EEEEEE;', 'width:300px; height:35px; ', 'width:300px; height:35px;' ,'']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          Formacionentrevista.clase = ['','','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          Formacionentrevista.sololectura = [false,true,false,true,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          Formacionentrevista.completar = ['off','off','off','off','off','off','off']; //autocompleta 
          
          Formacionentrevista.opciones = ['','','','',formacion,Cumplimiento,'']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          Formacionentrevista.funciones  = ['','','','',evaluacionformacion,'',''];


// // multiregistro habilidad Entrevista tercera multiregistro OPCION Habilidades propias del cargo
       
          Habilidadentrevista = new Atributos('Habilidadentrevista','HabilidadEntrevista_Modulo','Habilidadentrevistadescripcion_');

          Habilidadentrevista.campoid = 'idEntrevistaHabilidad';  //hermanitas             
          Habilidadentrevista.campoEliminacion = 'eliminarHabilidadEntrevista';//hermanitas         Cuando se utilice la funcionalidad 
          Habilidadentrevista.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          Habilidadentrevista.campos = ['idEntrevistaHabilidad','nombrePerfilCargo','PerfilCargo_idRequerido_Habilidad','porcentajeCargoHabilidad','PerfilCargo_idAspirante_Habilidad','calificacionEntrevistaHabilidad','Entrevista_idEntrevista']; //[arrays ]
          Habilidadentrevista.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          Habilidadentrevista.etiqueta = ['input','input','input','input','select','select','input'];
          Habilidadentrevista.tipo = ['hidden','text','hidden','text','hidden','','hidden']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          Habilidadentrevista.estilo = ['', 'width:260px; height:35px; background-color:#EEEEEE;', '', 'width:100px; height:35px;background-color:#EEEEEE;', 'width:300px; height:35px; ', 'width:300px; height:35px;' ,'']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          Habilidadentrevista.clase = ['','','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          Habilidadentrevista.sololectura = [false,true,false,true,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          Habilidadentrevista.completar = ['off','off','off','off','off','off','off']; //autocompleta 
          
          Habilidadentrevista.opciones = ['','','','',habilidad,Cumplimiento,'']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          Habilidadentrevista.funciones  = ['','','','',evaluacionhabilidad,'',''];



// // multiregistro  Hijos Conyugue 

        
          EntrevistaHijoPregunta = new Atributos('EntrevistaHijoPregunta','EntrevistaHijo_Modulo','EntrevistaHijodescripcion_');

          EntrevistaHijoPregunta.campoid = 'idEntrevistaHijo';  //hermanitas             
          EntrevistaHijoPregunta.campoEliminacion = 'eliminarEntrevistaHijo';//hermanitas         Cuando se utilice la funcionalidad 
          EntrevistaHijoPregunta.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EntrevistaHijoPregunta.campos = ['idEntrevistaHijo','Entrevista_idEntrevista','nombreEntrevistaHijo','edadEntrevistaHijo','ocupacionEntrevistaHijo']; //[arrays ]
          EntrevistaHijoPregunta.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EntrevistaHijoPregunta.etiqueta = ['input','input','input','input','input'];
          EntrevistaHijoPregunta.tipo = ['hidden','hidden','text','text','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EntrevistaHijoPregunta.estilo = ['', '', 'width: 300px;height:35px;','width: 78px;height:35px','width: 300px;height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EntrevistaHijoPregunta.clase = ['','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EntrevistaHijoPregunta.sololectura = [false,false,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EntrevistaHijoPregunta.completar = ['off','off','off','off','off']; //autocompleta 
          
          EntrevistaHijoPregunta.opciones = ['','','','','']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EntrevistaHijoPregunta.funciones  = ['','','','',''];

       

// // multiregistro  Relacioon Familiar

        
          EntrevistaRelacion = new Atributos('EntrevistaRelacion','EntrevistaRelacionFamilia_Modulo','EntrevistaRelacionFamiliadescripcion_');

          EntrevistaRelacion.campoid = 'idEntrevistaRelacionFamiliar';  //hermanitas             
          EntrevistaRelacion.campoEliminacion = 'eliminarEntrevistaRelacionFamilia';//hermanitas         Cuando se utilice la funcionalidad 
          EntrevistaRelacion.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EntrevistaRelacion.campos = ['idEntrevistaRelacionFamiliar','Entrevista_idEntrevista','parentescoEntrevistaRelacionFamiliar','relacionEntrevistaRelacionFamiliar']; //[arrays ]
          EntrevistaRelacion.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EntrevistaRelacion.etiqueta = ['input','input','select','select'];
          EntrevistaRelacion.tipo = ['hidden','hidden','select','select']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EntrevistaRelacion.estilo = ['', '', 'width: 500px;height:35px;','width: 500px;height:35px']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EntrevistaRelacion.clase = ['','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EntrevistaRelacion.sololectura = [false,false,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EntrevistaRelacion.completar = ['off','off','off','off']; //autocompleta 
          
          EntrevistaRelacion.opciones = ['','',ParentescoFamiliar,Relacionfamiliar]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EntrevistaRelacion.funciones  = ['','','',''];

        

          EntrevistaCompentencia = new Atributos('EntrevistaCompentencia','EntrevistaCompetencia_Modulo','EntrevistaCompetenciadescripcion_');

          EntrevistaCompentencia.campoid = 'idEntrevistaCompetencia';  //hermanitas             
          EntrevistaCompentencia.campoEliminacion = 'eliminarcompetencia';//hermanitas         Cuando se utilice la funcionalidad 
          EntrevistaCompentencia.botonEliminacion = false;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          EntrevistaCompentencia.campos = ['idEntrevistaCompetencia','CompetenciaPregunta_idCompetenciaPregunta','preguntaCompetenciaPregunta','CompetenciaRespuesta_idCompetenciaRespuesta']; //[arrays ]
          EntrevistaCompentencia.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          EntrevistaCompentencia.etiqueta = ['input','input','input','select'];
          EntrevistaCompentencia.tipo = ['hidden','hidden','text','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          EntrevistaCompentencia.estilo = ['','','width: 800px;height:35px;background-color:#EEEEEE;','width: 300px;height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          EntrevistaCompentencia.clase = ['','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          EntrevistaCompentencia.sololectura = [false,false,true,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          EntrevistaCompentencia.completar = ['off','off','off','off']; //autocompleta 
          
          EntrevistaCompentencia.opciones = ['','','',respuesta]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          EntrevistaCompentencia.funciones  = ['','','','']; 



        //Llenado de campos de las Multiregistros  EntrevistaHijoPregunta 
              for(var j=0, k = parentesco.length; j < k; j++)
                 {
              
                   EntrevistaHijoPregunta.agregarCampos(JSON.stringify(parentesco[j]),'L');
                 
                }

         // EntrevistaRelacion
            for(var j=0, k = relacion.length; j < k; j++)
                 {
                
                   EntrevistaRelacion.agregarCampos(JSON.stringify(relacion[j]),'L');
             
                }     


                // Competenica Pestaña de Habilidades
            for(var j=0, k = entrevistacompetenciap.length; j < k; j++)
                 {
                
                   EntrevistaCompentencia.agregarCampos(JSON.stringify(entrevistacompetenciap[j]),'L');
             
                }  

                //Educacion 


                 for(var j=0, k = entrevistaeducacion.length; j < k; j++)
                   {
                  
                     Educacionentrevista.agregarCampos(JSON.stringify(entrevistaeducacion[j]),'L');

                     
                     
               
                  } 



                //Formacion
                   for(var j=0, k = entrevistaformacion.length; j < k; j++)
                   {
                  
                     Formacionentrevista.agregarCampos(JSON.stringify(entrevistaformacion[j]),'L');
               
                  } 

                    //Formacion

                   for(var j=0, k = entrevistahabilidades.length; j < k; j++)
                   {
                  
                     Habilidadentrevista.agregarCampos(JSON.stringify(entrevistahabilidades[j]),'L');
               
                  } 



  });



   

</script> 



                        <div id='form-section' >

                          <fieldset id="entrevista-form-fieldset">  

                                                                                <div class="form-group col-md-6">
                                                                                {!!Form::label('TipoIdentificacion_idTipoIdentificacion', 'Tipo ', array('class' => 'col-sm-2 control-label'))!!}
                                                                                <div class="col-sm-8">
                                                                                  <div class="input-group" style="padding-left:15px ">
                                                                                    <span class="input-group-addon">
                                                                                      <i class="fa fa-credit-card"></i>
                                                                                    </span>
                                                                                    {!!Form::select('TipoIdentificacion_idTipoIdentificacion',$tipoIdentificacion, (isset($tercero) ? $tercero->TipoIdentificacion_idTipoIdentificacion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de identificaci&oacute;n",'style'=>'width:265px;'])!!}
                                                                                  </div>
                                                                                </div>
                                                                              </div>

                                                              <!-- Cedula aspirante -->
                                                                    <div class="form-group col-md-6" id='test'>
                                                                        {!!Form::label('documentoAspiranteEntrevista', 'Cedula', array('class' => 'col-sm-2 control-label')) !!}
                                                                              <div class="col-sm-8">
                                                                                <div class="input-group" style="padding-left:25px ">
                                                                                  <span class="input-group-addon">
                                                                                    <i class="fa fa-barcode" aria-hidden="true"></i>
                                                                                  </span>
                                                                                  {!!Form::text('documentoAspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Cedula', 'autocomplete' => 'off'])!!}
                                                                                     {!!Form::hidden('Tercero_idAspirante', null, array('id' => 'Tercero_idAspirante')) !!}
                                                                                     {!!Form::hidden('idEntrevista', null, array('id' => 'idEntrevista')) !!}
                                                                                    {!!Form::hidden('Entrevista_idEntrevista', (isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->Entrevista_idEntrevista : null), array('id' => 'Entrevista_idEntrevista')) !!}

                                                                                      {!!Form::hidden('eliminarEducacionEntrevista',null, array('id' => 'eliminarEducacionEntrevista'))!!}

                                                                                      {!!Form::hidden('eliminarHabilidadEntrevista',null, array('id' => 'eliminarHabilidadEntrevista'))!!}

                                                                                      {!!Form::hidden('eliminarFormacionEntrevista',null, array('id' => 'eliminarFormacionEntrevista'))!!}
                                                                                      {!!Form::hidden('eliminarEntrevistaHijo',null, array('id' => 'eliminarEntrevistaHijo'))!!}
                                                                                      {!!Form::hidden('eliminarEntrevistaRelacionFamilia',null, array('id' => 'eliminarEntrevistaRelacionFamilia'))!!}
                                                                                      {!!Form::hidden('eliminarcompetencia',null, array('id' => 'eliminarcompetencia'))!!}   
                                                                                </div>
                                                                            </div>
                                                                    </div>
                                                                  



                                                                      <!-- Cargo -->
                                                                          <div class="form-group col-md-6" id='test'>
                                                                              {!!Form::label('Cargo_idCargo','Cargo',array('class' => 'col-sm-2 control-label')) !!}
                                                                                  <div class="col-sm-8">
                                                                                    <div class="input-group" style="padding-left:15px ">
                                                                                      <span class="input-group-addon">
                                                                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                                                                      </span>
                                                                              <!--     {!!Form::select('Cargo_idCargo',$cargo, (isset($entrevista) ? $entrevista->Cargo_idCargo : 0),["class" => "select form-control", "placeholder" =>"Seleccione", 'onchange'=>'llenarFormacionCargo,llenarEducacionCargo,llenarEntrevistaCompetencia(this.value)'])!!}
 -->

                                                                                {!!Form::select('Cargo_idCargo',$cargo, (isset($entrevista) ? $entrevista->Cargo_idCargo : 0),["class" => "select form-control", "placeholder" =>"Seleccione" ,'onchange'=>"llenarFormacionCargo(this.value); llenarEducacionCargo(this.value); llenarEntrevistaCompetencia(this.value,($('#idEntrevista').val() == 0 ? 'Nueva': ''));llenarHabilidadCargo(this.value);"])!!}
                                                                                    </div>
                                                                                  </div>
                                                                              </div>

                                                                                <!-- Estado Final -->
                                                                      <div class="form-group col-md-6" id='test'>
                                                                          {!!Form::label('estadoEntrevista', 'Estado Final', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-8">
                                                                              <div class="input-group" style="padding-left:25px ">
                                                                                <span class="input-group-addon">
                                                                                  <i class="fa fa-bars "></i>
                                                                                </span>

                                                                              {!! Form::select('estadoEntrevista', ['EnProceso' =>'En Proceso','Seleccionado' => 'Seleccionado','Rechazado'=>'Rechazado'],null,['class' => 'form-control',"placeholder"=>"Seleccione el estado"]) !!}                                     

                                                                              </div>
                                                                            </div>
                                                                      </div>

                                                                             

                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                            </br>
                                                                          </br>


                                                                                     <!-- Nombre 1 aspirante -->
                                                                              <div class="form-group col-md-6" id='test'>
                                                                                    {!!Form::label('nombre1AspiranteEntrevista', 'Nombre1', array('class' => 'col-sm-2 control-label')) !!}
                                                                                    <div class="col-sm-8">
                                                                                      <div class="input-group" style="padding-left:15px ">
                                                                                        <span class="input-group-addon">
                                                                                         <i class="fa fa-font" aria-hidden="true"></i>
                                                                                        </span>
                                                                                        {!!Form::text('nombre1AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Nombre', 'autocomplete' => 'off'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                                </div>


                                                                                        <!-- Nombre 2 aspirante -->
                                                                              <div class="form-group col-md-6" id='test'>
                                                                                    {!!Form::label('nombre2AspiranteEntrevista', 'Nombre2', array('class' => 'col-sm-2 control-label')) !!}
                                                                                    <div class="col-sm-8">
                                                                                      <div class="input-group" style="padding-left:25px ">
                                                                                        <span class="input-group-addon">
                                                                                          <i class="fa fa-font" aria-hidden="true"></i>
                                                                                        </span>
                                                                                        {!!Form::text('nombre2AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su segundo Nombre', 'autocomplete' => 'off'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                                </div>



                                        
                                                                                          <!-- Apellido 1 aspirante -->
                                                                            <div class="form-group col-md-6" id='test'>
                                                                                  {!!Form::label('apellido1AspiranteEntrevista','Apellido1', array('class' => 'col-sm-2 control-label')) !!}
                                                                                  <div class="col-sm-8">
                                                                                    <div class="input-group" style="padding-left:15px ">
                                                                                      <span class="input-group-addon">
                                                                                       <i class="fa fa-header" aria-hidden="true"></i>
                                                                                      </span>
                                                                                      {!!Form::text('apellido1AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su primer apellido', 'autocomplete' => 'off'])!!}
                                                                                    </div>
                                                                                  </div>
                                                                              </div>

                                                                                       <!-- Apellido 2 aspirante -->
                                                                            <div class="form-group col-md-6" id='test'>
                                                                                  {!!Form::label('apellido2AspiranteEntrevista','Apellido2', array('class' => 'col-sm-2 control-label')) !!}
                                                                                  <div class="col-sm-8">
                                                                                    <div class="input-group" style="padding-left:25px ">
                                                                                      <span class="input-group-addon">
                                                                                        <i class="fa fa-header" aria-hidden="true"></i>
                                                                                      </span>
                                                                                      {!!Form::text('apellido2AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su segundo apellido', 'autocomplete' => 'off'])!!}
                                                                                    </div>
                                                                                  </div>
                                                                              </div>

                                                                                       <!--  Entrevistador --> 
                                                                                <div class="form-group col-md-6" id='test'>
                                                                                    {!!Form::label('Tercero_idEntrevistador', 'Entrevistador', array('class' => 'col-sm-2 control-label')) !!}
                                                                                    <div class="col-sm-8">
                                                                                      <div class="input-group" style="padding-left:15px ">
                                                                                        <span class="input-group-addon">
                                                                                          <i class="fa fa-user" aria-hidden="true"></i>
                                                                                        </span>
                                                                                          {!!Form::select('Tercero_idEntrevistador',$Tercero, (isset($entrevista) ? $entrevista->Tercero_idEntrevistador : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                                                                      </div>
                                                                                    </div>
                                                                                </div>

                                                                                  <!-- Fecha Entrevista -->
                                                                                <div class="form-group col-md-6" id='test'>
                                                                                    {!!Form::label('fechaEntrevista', 'F.Entrevista ', array('class' => 'col-sm-2 control-label')) !!}
                                                                                    <div class="col-sm-8">
                                                                                      <div class="input-group" style="padding-left:25px ">
                                                                                        <span class="input-group-addon">
                                                                                          <i class="fa fa-calendar"></i>
                                                                                        </span>
                                                                                        {!!Form::text('fechaEntrevista',null,['class'=>'form-control','placeholder'=>'Seleccione la Fecha  de la Entrevista', 'autocomplete' => 'off'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                                </div>


                                                                                 <!-- Experiencia en Años -->
                                                                                <div class="form-group col-md-6" id='test'>
                                                                                    {!!Form::label('experienciaAspiranteEntrevista', 'Exp(Años)', array('class' => 'col-sm-2 control-label')) !!}
                                                                                    <div class="col-sm-8">
                                                                                      <div class="input-group" style="padding-left:15px ">
                                                                                        <span class="input-group-addon">
                                                                                          <i class="fa fa-level-up" aria-hidden="true"></i>
                                                                                        </span>
                                                                                        {!!Form::text('experienciaAspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Experiencia en Años', 'autocomplete' => 'off', 'onblur'=>'compararAniosExperiencia(this.value)'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                                </div>

                                                                                       <!-- Requerida -->
                                                                                  <div class="form-group col-md-6" id='test' >
                                                                                      {!!Form::label('experienciaRequeridaEntrevista', 'Exp.Requerida', array('class' => 'col-sm-2 control-label')) !!}
                                                                                      <div class="col-sm-8" style="padding-left:40px ">
                                                                                        <div class="input-group">
                                                                                          <span class="input-group-addon">
                                                                                           <i class="fa fa-gavel" aria-hidden="true"></i>
                                                                                          </span>
                                                                                          {!!Form::text('experienciaRequeridaEntrevista',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                          
                                                                                        </div>
                                                                                      </div>
                                                                                 </div>                          
                      </fieldset>                                          
                  </div>
 <input type="hidden" id="token" value="{{csrf_token()}}"/>
                                              <!-- OPCIONES DEL FORMULARIO  -->  

                                        
                            <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab"  onclick="mostrarDivGenerales('General')" href="#General">Habilidades propias del Cargo</a></li> <!-- Se hizo un cambio para evitar cambiar la funciones de los divs nada mas se le cambia el nombre a competencia y Generales -->
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Competencias')" href="#Competencias">Generales</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Habilidades')" href="#Habilidades">Habilidades actitudinales</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('otraspreguntas')" href="#otraspreguntas">Otras Preguntas</a></li>

                              </ul>

    <div class="tab-content">
                                                    <div id="General" class="tab-panel fade in active" >
                                                              <div class="form-group">
                                                                  <div class="panel panel-default">
                                                                        <!-- <div class="panel-heading">General</div> -->
                                                                      <div class="panel-body">
                                                                          <div class="panel-group" id="accordion">
                                                                                    <!-- Educacion -->
                                                                                <div class="panel panel-default">
                                                                                  <div class="panel-heading">
                                                                                    <h4 class="panel-title">
                                                                                      <a data-toggle="collapse" data-parent="#accordion" href="#Educacion">Educacion</a>
                                                                                    </h4>
                                                                                  </div>
                                                                                  <div id="Educacion" class="panel-collapse collapse">
                                                                                    <div class="panel-body">
                                                                                                        <!-- Detalle Educacion  -->
                                                                                          <div class="form-group" id='test'>
                                                                                              <div class="col-sm-12">

                                                                                                <div class="row show-grid">
                                                                                                  
                                                                                                  <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                                                 <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                                                 <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>

                                                                                                 <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Cumple </div>

                                                                                                
                                                                                                  <!-- este es el div para donde van insertando los registros --> 
                                                                                                  <div id="EducacionEntrevista_Modulo">
                                                                                                  </div>

                                                                                                </div>
                                                                                                                    <!-- nuevo campo para Calificacion  -->
                                                                                                 <div class="form-group" id='test' >
                                                                                                  {!!Form::label('calificacionEducacionEntrevista', 'Calificación', array('class' => 'col-sm-1 control-label'))!!}
                                                                                                  <div class="col-sm-10">
                                                                                                    <div class="input-group" style="padding-left:10px ">
                                                                                                      <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                                      </span>
                                                                                                      {!!Form::text('calificacionEducacionEntrevista',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                                    </div>
                                                                                                  </div>
                                                                                                </div>
                                                                                              </div>
                                                                                            </div> 
                                                                                    </div>
                                                                
                                                                                  </div>

                                                                                </div>  
                                                                                                  <!-- FORMACION -->
                                                                            <div class="panel panel-default">
                                                                                  <div class="panel-heading">
                                                                                    <h4 class="panel-title">
                                                                                      <a data-toggle="collapse" data-parent="#accordion" href="#Formacion">Formacion</a>
                                                                                    </h4>
                                                                                  </div>
                                                                                      <div id="Formacion" class="panel-collapse collapse">  
                                                                                            <div class="panel-body">
                                                                                                       <!-- Detalle Formacion  -->
                                                                                                  <div class="form-group" id='test'>
                                                                                                      <div class="col-sm-12">

                                                                                                        <div class="row show-grid">
                                                                                                          <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                                                         <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                                                         <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>
                                                                                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Cumple </div>
                                                                                                        
                                                                                                          <!-- este es el div para donde van insertando los registros --> 
                                                                                                          <div id="FormacionEntrevista_Modulo">
                                                                                                          </div>
                                                                                                        </div>
                                                                                                                          <!-- nuevo campo para Calificacion  -->
                                                                                                         <div class="form-group" id='test' >
                                                                                                          {!!Form::label('calificacionFormacionEntrevista', 'Calificación', array('class' => 'col-sm-1 control-label'))!!}
                                                                                                          <div class="col-sm-10">
                                                                                                            <div class="input-group" style="padding-left:10px ">
                                                                                                              <span class="input-group-addon">
                                                                                                                <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                                              </span>
                                                                                                              {!!Form::text('calificacionFormacionEntrevista',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                                            </div>
                                                                                                          </div>
                                                                                                        </div>
                                                                                                      </div>
                                                                                                    </div> 
                                                                                                  </div>
                                                                                         </div>
                                                                              </div>  
                                                                                                      <!-- habilidades -->
                                                                            <div class="panel panel-default">
                                                                                  <div class="panel-heading">
                                                                                    <h4 class="panel-title">
                                                                                      <a data-toggle="collapse" data-parent="#accordion" href="#Habilidadesinterno">Habilidades propias del Cargo</a>
                                                                                    </h4>
                                                                                  </div>
                                                                                      <div id="Habilidadesinterno" class="panel-collapse collapse">  
                                                                                            <div class="panel-body">
                                                                                                       <!-- Detalle habilidad  -->
                                                                                                  <div class="form-group" id='test'>
                                                                                                      <div class="col-sm-12">

                                                                                                        <div class="row show-grid">
                                                                                                          <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                                                         <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                                                         <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>
                                                                                                        <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Cumple </div>
                                                                                                        
                                                                                                          <!-- este es el div para donde van insertando los registros --> 
                                                                                                          <div id="HabilidadEntrevista_Modulo">
                                                                                                          </div>
                                                                                                        </div>
                                                                                                                  <!-- nuevo campo para Calificacion  -->
                                                                                                         <div class="form-group" id='test' >
                                                                                                          {!!Form::label('calificacionHabilidadCargoEntrevista', 'Calificación', array('class' => 'col-sm-1 control-label'))!!}
                                                                                                          <div class="col-sm-10">
                                                                                                            <div class="input-group" style="padding-left:10px ">
                                                                                                              <span class="input-group-addon">
                                                                                                                <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                                              </span>
                                                                                                              {!!Form::text('calificacionHabilidadCargoEntrevista',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
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
                                                  </div>


                                                                            <!-- OPCION 2 -->

            <div id="Competencias" class="tab-pane fade ">
                                          <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                                          <li class="active"><a data-toggle="tab" onclick="mostrarDivInternos('aspectopersonal')" href="#aspectopersonal">Aspectos Personales</a></li>
                                        
                                          <li class=""><a data-toggle="tab"  onclick="mostrarDivInternos('educativo')" href="#educativo">Educativos</a></li>
                                          <li class=""><a data-toggle="tab"  onclick="mostrarDivInternos('laboral')" href="#laboral">Laborales</a></li>
                                          <li class=""><a data-toggle="tab"  onclick="mostrarDivInternos('sociales')" href="#sociales">Sociales/Personalidad</a></li>

                                          </ul>
                                               
                                                    <!-- OPCION ASPECTOS PERSONALES -->
                                       <div id="aspectopersonal" class="tab-panel fade in active" >
                                           <div class="entrevista-container">
                                               <div class="panel panel-default" > 
                                                   <!-- Fecha de Nacimiento  --> 
                                                            <div class="form-group">
                                                                <div class="panel-body"> 

                                                                  <div class="form-group" id='test'>
                                                                                 {!!Form::label('fechaNacimientoEntrevistaPregunta', 'F.Nacimiento', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                <div class="col-sm-5 ">
                                                                                                        <div class="input-group">
                                                                                                                 <span class="input-group-addon">
                                                                                                                        <i class="fa fa-calendar"></i>
                                                                                                                 </span> 
                                                                                           {!!Form::text('fechaNacimientoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Seleccione su Fecha de Nacimiento','onblur'=>'consultarEdadEntrevistado(this.value)'])!!}
                                                                                                           </div> 
                                                                                                </div>
                                                                                                <!-- EDAD ENTREVISTA -->
                                                                                              <div class="form-group" id='test'>
                                                                                                 {!!Form::label('edadEntrevistaPregunta', 'Edad', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                      <div class="col-sm-3">
                                                                                                            <div class="input-group">
                                                                                                                   <span class="input-group-addon">
                                                                                                          <i class="fa fa-calendar"></i>
                                                                                                                   </span>
                                                                                      {!!Form::text('edadEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->edadEntrevistaPregunta : null),['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                                               </div>
                                                                                                      </div>
                                                                                             </div>
                                                                                </div>
                                                                                 <!--   Estado Civil  -->
                                                                                              <div class="form-group" id='test'>
                                                                                                 {!!Form::label('estadoCivilEntrevistaPregunta', 'Estado Civil', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                      <div class="col-sm-10">
                                                                                                          <div class="input-group">
                                                                                                                 <span class="input-group-addon">
                                                                                                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                                                                                                 </span>
                                                                     {!!Form::select('estadoCivilEntrevistaPregunta',
                                                        array('CASADO'=>'Casado','SOLTERO'=>'Soltero'),(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->estadoCivilEntrevistaPregunta : null),["class" => "js-example-placeholder-single js-states form-control", "placeholder" =>"Seleccione el estado civil"])!!}
                                                                                                             </div>
                                                                                                      </div>
                                                                                             </div>
                                                                                             </br>
                                                                                </br>
                                                                                </br>
                                                                                </br>
                                                                            <div class="form-group" id='test'>
                                                                                 {!!Form::label('telefonoEntrevistaPregunta', 'Telefono', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                <div class="col-sm-5 ">
                                                                                                        <div class="input-group">
                                                                                                                 <span class="input-group-addon">
                                                                                                                         <i class="fa fa-mobile" aria-hidden="true"></i>
                                                                                                                 </span>
                                                                                           {!!Form::text('telefonoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->telefonoEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su telefono'])!!}
                                                                                                           </div>
                                                                                                </div>

                                                                                              <div class="form-group" id='test'>
                                                                                                 {!!Form::label('movilEntrevistaPregunta', 'Mòvil', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                      <div class="col-sm-3">
                                                                                                            <div class="input-group">
                                                                                                                   <span class="input-group-addon">
                                                                                                                          <i class="fa fa-mobile" aria-hidden="true"></i>
                                                                                                                   </span>
                                                                                      {!!Form::text('movilEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->movilEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Movil'])!!}
                                                                                                               </div>
                                                                                                      </div>
                                                                                             </div>
                                                                                </div>

                                                                         

                                                                                              <!-- CORREO ELECTRONICO  -->
                                                                                              <div class="form-group" id='test'>
                                                                                                 {!!Form::label('correoElectronicoEntrevistaPregunta', 'Correo E', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                      <div class="col-sm-10">
                                                                                                          <div class="input-group">
                                                                                                                 <span class="input-group-addon">
                                                                                                            <i class="fa fa-at" aria-hidden="true"></i>
                                                                                                                 </span>
                                                                                                                     {!!Form::text('correoElectronicoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->correoElectronicoEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Correo Electronico'])!!}
                                                                                                             </div>
                                                                                                      </div>
                                                                                             </div>

                                                                                                <div class="form-group" id='test'>
                                                                                                   {!!Form::label('direccionEntrevistaPregunta', 'Direccion', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                    <div class="col-sm-10">
                                                                                                          <div class="input-group">
                                                                                                                 <span class="input-group-addon">
                                                                                                                       <i class="fa fa-road" aria-hidden="true"></i>
                                                                                                                 </span>
                                                                                                                     {!!Form::text('direccionEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->direccionEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Direccion'])!!}
                                                                                                           </div>
                                                                                                    </div>
                                                                                               </div>

                                                                                                 <div class="form-group" id='test'>
                                                                                                     {!!Form::label('Ciudad_idResidencia', 'Ciudad', array('class' => 'col-sm-2 control-label')) !!}
                                                                                                      <div class="col-sm-10">
                                                                                                           <div class="input-group">
                                                                                                               <span class="input-group-addon">
                                                                                                                      <i class="fa fa-university" aria-hidden="true"></i>
                                                                                                               </span>
                                                                                          {!!Form::select('Ciudad_idResidencia',$Ciudad_idResidencia, (isset($entrevista) ? $entrevista->EntrevistaPregunta->Ciudad_idResidencia : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                                                                                           </div>
                                                                                                      </div>
                                                                                                 </div>
                                                                                      </br>
                                                                      <!-- DATOS DEL CONYUGUE  -->
                                                                     <font color = "000000">Datos del Conyuge</font> 
                                                                                   <!-- nombreConyugeEntrevistaPregunta  -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('nombreConyugeEntrevistaPregunta','Nombre',array('class' => 'col-sm-2 control-label')) !!}
                                                                              <div class="col-sm-10">
                                                                                <div class="input-group">
                                                                                       <span class="input-group-addon">
                                                                                              <i class="fa fa-font" aria-hidden="true"></i>
                                                                                       </span>
                                                                                           {!!Form::text('nombreConyugeEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->nombreConyugeEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Nombre'])!!}
                                                                                   </div>
                                                                              </div>
                                                                         </div>
                                                                                        <!-- Ocupacion conyugue -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('ocupacionConyugeEntrevistaPregunta','Ocupacion', array('class' => 'col-sm-2 control-label')) !!}
                                                                              <div class="col-sm-10">
                                                                                  <div class="input-group">
                                                                                         <span class="input-group-addon">
                                                                                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                                                                         </span>
                                                                                             {!!Form::text('ocupacionConyugeEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->ocupacionConyugeEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Ocupación'])!!}
                                                                                   </div>
                                                                              </div>
                                                                         </div>
                                                                                       <!--  Numero de Hijos Conyugue -->
                                                                         <div class="form-group" id='test'>
                                                                             {!!Form::label('numeroHijosEntrevistaPregunta','Número Hijos', array('class' => 'col-sm-2 control-label')) !!}
                                                                                <div class="col-sm-10">
                                                                                    <div class="input-group">
                                                                                           <span class="input-group-addon">
                                                                                                 <i class="fa fa-users" aria-hidden="true"></i>
                                                                                           </span>
                                                                                               {!!Form::text('numeroHijosEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->numeroHijosEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese Número de Hijos'])!!}
                                                                                    </div>
                                                                                </div>
                                                                         </div>

                                                                                <!-- MULTIREGISTRO HIJOS  -->
                                                            
                                                                        <div class="form-group" id='test'>
                                                                              <div class="col-sm-12">

                                                                                <div class="row show-grid">
                                                                                  <div class="col-md-1" style="width: 40px;height: 35px;" onclick="EntrevistaHijoPregunta.agregarCampos(competenciamodelo,'A')">
                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                                  </div>
                                                                                  <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Nombre</div>
                                                                                  <div class="col-md-1" style="width: 78px;display:inline-block;height:35px;">Edad</div>
                                                                                  <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Ocupación</div>
                                                                                 
                                                                                    

                                                                                  <!-- este es el div para donde van insertando los registros --> 
                                                                                  <div id="EntrevistaHijo_Modulo">
                                                                                  </div>

                                                                                   </div>
                                                                               
                                                                              </div>
                                                                        </div>  
                                                                        

                                                                         
                                                                          <!-- Con quien vive   -->
                                                                            <div style="display:inline-block; class="form-group" id='test'>
                                                                               {!!Form::label('conQuienViveEntrevistaPregunta','Con quien vive', array('class' => 'col-sm-1 control-label')) !!}
                                                                                  <div class="col-sm-10">
                                                                                        <div class="input-group">
                                                                                             <span class="input-group-addon">
                                                                                                   <i class="fa fa-users" aria-hidden="true"></i>
                                                                                             </span>
                                                                                                 {!!Form::text('conQuienViveEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->conQuienViveEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese con quien Vive'])!!}
                                                                                         </div>
                                                                                  </div>
                                                                           </div>
                                                                            </br>
                                                                          </br>
                                                                        
          
                                                                                        <!--  Donde Vive -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('dondeViveEntrevistaPregunta','DondeVive', array('class' => 'col-sm-1 control-label')) !!}
                                                                                <div class="col-sm-10">
                                                                                      <div class="input-group">
                                                                                             <span class="input-group-addon">
                                                                                                    <i class="fa fa-road" aria-hidden="true"></i>
                                                                                             </span>
                                                                                                 {!!Form::text('dondeViveEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->dondeViveEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese Donde Vive'])!!}
                                                                                       </div>
                                                                                </div>
                                                                         </div>

                                                                        </br>
                                                                          </br>
                                                                      
                                                                                       <!--  Ocupacion Actual -->
                                                                         <div class="form-group" id='test'>
                                                                             {!!Form::label('ocupacionActualEntrevistaPregunta','Ocupación', array('class' => 'col-sm-1 control-label')) !!}
                                                                              <div class="col-sm-10">
                                                                                <div class="input-group">
                                                                                       <span class="input-group-addon">
                                                                                              <i class="fa fa-tasks" aria-hidden="true"></i>
                                                                                       </span>
                                                                                           {!!Form::text('ocupacionActualEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->ocupacionActualEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Ocupación actual'])!!}
                                                                                   </div>

                                                                              </div>
                                                                         </div>
                                                                       </br>
                                                                  </br>
                                                               </br>
                                                            </br>
                                                                  <center><font  color = "000000">Como es su Relacion con</font></center>
                                                                     <!--  HTML Multiregistro   -->                                           
                                                                <div class="form-group" id='test'>
                                                                          <div class="col-sm-12">

                                                                              <div class="row show-grid">
                                                                                  <div class="col-md-1" style="width: 40px;height: 35px;" onclick="EntrevistaRelacion.agregarCampos(Relacionfamilia,'A')">
                                                                                    <span class="glyphicon glyphicon-plus"></span>
                                                                                  </div>
                                                                                  <div class="col-md-1" style="width: 500px;display:inline-block;height:35px;"> </div>
                                                                                  <div class="col-md-1" style="width: 500px;display:inline-block;height:35px;"></div>
                                                                                

                                                                                  <!-- este es el div para donde van insertando los registros --> 
                                                                                  <div id="EntrevistaRelacionFamilia_Modulo">
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                </div>  

                                                         

                                                           
                                                </div>
                                             </div>               
                                          </div>
                                     </div>                               
                              </div>

                               
                                                    <!-- educativos -->
                                      <div id="educativo" class="tab-panel fade" style="display:none;" >
                                            <div class="educativo-container">
                                                  <div class="panel panel-default" > 
                                                             <!-- Estudia Actualmente -->
                                                              <div class="panel-body">
                                                               <font color = "000000">Estudia Actualmente </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('estudioActualEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->estudioActualEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Ingresa la convocatoria'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div>
                                                                 <!-- Cual es su horario de Estudio -->
                                                              <div class="panel-body">
                                                               <font color = "000000">Cual es su horario de Estudio?</font>
                                                                  <div class="form-group" id='test'>
                                                                        <div class="col-sm-10" style="width: 100%;">
                                                                          <div class="input-group">
                                                                            {!!Form::textarea('horarioEstudioEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->horarioEstudioEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Cual es su horario de Estudio'])!!}
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                 <!-- Que lo motivó elegir su carrera?  -->
                                                              <div class="panel-body">
                                                                <font color = "000000">Que lo motivó elegir su carrera? </font>
                                                                    <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('motivacionCarreraEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->motivacionCarreraEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                    </div>
                                                              </div>
                                                                 <!--Cuales son sus expectativas de estudio? -->      
                                                                <div class="panel-body">
                                                                 <font color = "000000">Cuales son sus expectativas de estudio? </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('expectativaEstudioEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->expectativaEstudioEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div>                            
                                                       </div>
                                                 </div>
                                      </div>
                                                          <!-- laborales -->
                                                <div id="laboral" class="tab-panel fade" style="display:none;">
                                                      <div class="laboral-container">
                                                          <div class="panel panel-default" > 

                                                                   <!-- Ultimo empleo -->
                                                                          <div class="panel-body">
                                                                             <font color = "000000">Cual fue el Último Empleo que tuvo?</font>
                                                                              <div class="form-group" id='test'>
                                                                                    <div class="col-sm-10" style="width: 100%;">
                                                                                      <div class="input-group">
                                                                                        {!!Form::textarea('ultimoEmpleoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->ultimoEmpleoEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Cual fue el Último Empleo que tuvo?'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                           <!-- Funciones Principales -->
                                                                          <div class="panel-body">
                                                                           <font color = "000000">Funciones Principales</font>
                                                                              <div class="form-group" id='test'>
                                                                                    <div class="col-sm-10" style="width: 100%;">
                                                                                      <div class="input-group">
                                                                                        {!!Form::textarea('funcionesEmpleoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->funcionesEmpleoEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Digite sus Funciones Principales'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                              </div>
                                                                          </div>
                                                                           <!-- Logros Obtenidos -->
                                                                        
                                                                          <div class="panel-body">
                                                                           <font color = "000000">Logros Obtenidos </font>
                                                                                <div class="form-group" id='test'>
                                                                                      <div class="col-sm-10" style="width: 100%;">
                                                                                        <div class="input-group">
                                                                                          {!!Form::textarea('logrosEmpleoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->logrosEmpleoEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Digite los logros Obtenidos'])!!}
                                                                                        </div>

                                                                                             
                                                                                             </br>
                                                                                             </br>
                                                                                         <!-- ULTIMO SALARIO  -->
                                                                                <div class="form-group" id='test'>
                                                                                   {!!Form::label('ultimoSalarioEntrevistaPregunta', 'UltimoSalario', array('class' => 'col-sm-1 control-label')) !!}
                                                                                        <div class="col-sm-7">
                                                                                              <div class="input-group">
                                                                                                   <span class="input-group-addon">
                                                                                                          <i class="fa fa-usd" aria-hidden="true"></i>
                                                                                                   </span>
                                                                                                       {!!Form::text('ultimoSalarioEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->ultimoSalarioEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Ultimo Salario'])!!}
                                                                                               </div>
                                                                                        </div>
                                                                               </div>
                                                                               </br>

                                                                                         <!-- Motivo de Su Retiro   -->
                                                                                <div class="form-group" id='test'>
                                                                                   {!!Form::label('motivoRetiroEntrevistaPregunta', 'MotivoRetiro', array('class' => 'col-sm-1 control-label')) !!}
                                                                                        <div class="col-sm-7">
                                                                                              <div class="input-group">
                                                                                                   <span class="input-group-addon">
                                                                                                          <i class="fa fa-external-link" aria-hidden="true"></i>
                                                                                                   </span>
                                                                                                       {!!Form::text('motivoRetiroEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->motivoRetiroEntrevistaPregunta : null),['class'=> 'form-control','placeholder'=>'Por favor Ingrese el Motivo de su Retiro'])!!}
                                                                                               </div>
                                                                                        </div>
                                                                               </div>
                                                                                            </br>
                                                                                             </br>
                                                                                  <!-- Cuales son sus Espectativas Laborales-->
                                                                          <div class="panel-body">
                                                                           <font color = "000000">Cuales son sus expectativas laborales</font>
                                                                              <div class="form-group" id='test'>
                                                                                    <div class="col-sm-10" style="width: 100%;">
                                                                                      <div class="input-group">
                                                                                        {!!Form::textarea('expectativaLaboralEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->expectativaLaboralEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Espectativas'])!!}
                                                                                      </div>
                                                                                    </div>
                                                                              </div>
                                                                          </div>

                                                                                    <!-- Disponibilidad para Comenzar  -->
                                                                                <div class="form-group" id='test'>
                                                                                   {!!Form::label('disponibilidadInicioEntrevistaPregunta', 'Disponibilidad para Comenzar', array('class' => 'col-sm-1 control-label')) !!}
                                                                                        <div class="col-sm-7">
                                                                                              <div class="input-group">
                                                                                                   <span class="input-group-addon">
                                                                                                          <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                                                                   </span>
                                                              {!! Form::select('disponibilidadInicioEntrevistaPregunta',['Inmediata'=>'Inmediata','quincedias' => '15 dias','mes'=>'1 mes o mas'],(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->disponibilidadInicioEntrevistaPregunta : null),['class' => 'form-control',"placeholder"=>"Seleccione la disponibilidad"]) !!}    
                                                                                                       
                                                                                               </div>
                                                                                        </div>
                                                                               </div>
                                                                               </br>
                                                                               </br>
                                                                               </br>
                                                                               </br>

                                                                                         <!-- Cual es su aspiracion Salarial   -->
                                                                                <div class="form-group" id='test'>
                                                                                   {!!Form::label('aspiracionSalarialEntrevistaPregunta', 'Aspiracion Salarial?', array('class' => 'col-sm-1 control-label')) !!}
                                                                                        <div class="col-sm-7">
                                                                                              <div class="input-group">
                                                                                                   <span class="input-group-addon">
                                                                                                          <i class="fa fa-usd" aria-hidden="true"></i>
                                                                                                   </span>
                                                                                                       {!!Form::text('aspiracionSalarialEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Cual es su aspiracion Salarial'])!!}
                                                                                               </div>
                                                                                        </div>
                                                                               </div>
                                                                               </br>
                                                                               </br>
                                                                               </br>
                                                                               </br>
                                                                                          <!-- Que le motivó  a trabajar con nosotros? -->
                                                                          <div class="panel-body">
                                                                             <font color = "000000">Que le motivó  a trabajar con nosotros?</font>
                                                                              <div class="form-group" id='test'>
                                                                                    <div class="col-sm-10" style="width: 100%;">
                                                                                      <div class="input-group">
                                                                                        {!!Form::textarea('motivacionTrabajoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->motivacionTrabajoEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Cual fue el Último Empleo que tuvo?'])!!}
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
                                            <!-- socialespersonalidad -->
                                 <div id="sociales" class="tab-panel fade" style="display:none;">
                                     <div class="entrevista-container">
                                         <div class="panel panel-default" > 

                                                       <!-- Como se ve usted dentro de 5 años? -->
                                                              <div class="panel-body">
                                                               <font color = "000000"> Como se ve usted dentro de 5 años? </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('proyeccion5AñosEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->proyeccion5AñosEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Ingresa la convocatoria'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div>
                                                                 <!--Que hace en los tiempos libres? -->
                                                              <div class="panel-body">
                                                               <font color = "000000">Que hace en los tiempos libres?</font>
                                                                  <div class="form-group" id='test'>
                                                                        <div class="col-sm-10" style="width: 100%;">
                                                                          <div class="input-group">
                                                                            {!!Form::textarea('tiempoLibreEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->tiempoLibreEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'Cual es su horario de Estudio'])!!}
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                 <!-- Se considera introvertido o extrovertido? ¿Por qué?  -->
                                                              <div class="panel-body">
                                                                <font color = "000000">Se considera introvertido o extrovertido? ¿Por qué? </font>
                                                                    <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('introvertidoEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->introvertidoEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                    </div>
                                                              </div>
                                                                <!--Fuma o consume licor? ¿Con que frecuencia?-->      
                                                                <div class="panel-body">
                                                                 <font color = "000000">Fuma o consume licor? ¿Con que frecuencia? </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('vicioEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->vicioEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div> 
                                                                 <!--Ha tenido algún inconveniente con la ley? ¿Por qué?-->      
                                                                <div class="panel-body">
                                                                 <font color = "000000">Ha tenido algún inconveniente con la ley? ¿Por qué? </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('antecedentesEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->antecedentesEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div>  

                                                                   <!--Que cosas sobresalientes o importantes le han pasado en la vida, que quiera contar?-->      
                                                                <div class="panel-body">
                                                                 <font color = "000000">Que cosas sobresalientes o importantes le han pasado en la vida, que quiera contar? </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('anecdotaEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->anecdotaEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div> 
                                                                   <!--Observaciones-->      
                                                                <div class="panel-body">
                                                                 <font color = "000000">Observaciones </font>
                                                                      <div class="form-group" id='test'>
                                                                            <div class="col-sm-10" style="width: 100%;">
                                                                              <div class="input-group">
                                                                                {!!Form::textarea('observacionEntrevistaPregunta',(isset($entrevista->EntrevistaPregunta) ? $entrevista->EntrevistaPregunta->observacionEntrevistaPregunta : null),['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                                              </div>
                                                                            </div>
                                                                      </div>
                                                                </div>      
                                                                                    
                                         </div>
                                     </div>
                               </div>
            </div>                
                          <!-- OPCION 3 -->
                                         <div id="Habilidades" class="tab-pane fade">
                                                                     <!--  HTML Multiregistro  Habilidades sin Boton de Agregar solo con Ajax  -->                                           
                                                                <div class="form-group" id='test'>
                                                                          <div class="col-sm-12">

                                                                              <div class="row show-grid">
                                                                                  <div class="col-md-1" style="width: 800px;display:inline-block;height:35px;">Pregunta </div>
                                                                                  <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Respuesta</div>
                                                                                

                                                                                  <!-- este es el div para donde van insertando los registros --> 
                                                                                  <div id="EntrevistaCompetencia_Modulo">
                                                                                  </div>
                                                                              </div>
                                                                          </div>  
                                                                          <!-- Campo para agregar en Habilidades actudinales CALIFICAR  -->
                                                                                    <!-- nuevo campo para Calificacion  -->
                                                                                                 <div class="form-group" id='test' >
                                                                                                  {!!Form::label('calificacionHabilidadActitudinalEntrevista', 'Calificación', array('class' => 'col-sm-1 control-label'))!!}
                                                                                                  <div class="col-sm-10">
                                                                                                    <div class="input-group" style="padding-left:10px ">
                                                                                                      <span class="input-group-addon">
                                                                                                        <i class="fa fa-pencil-square-o" style="width: 14px;"></i>
                                                                                                      </span>
                                                                                                      {!!Form::text('calificacionHabilidadActitudinalEntrevista',null,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                                                                                    </div>
                                                                                                  </div>
                                                                                                </div>
                                                                </div> 
                                        
                                        </div>

                                                     <!--  OOPCION 4 -->
                                       <div id="otraspreguntas" class="tab-pane fade">
                                         <div clas="col-sm-12">
                                         {!!Form::select('Encuesta_idEncuesta',$encuesta, (isset($entrevista) ? $entrevista->Encuesta_idEncuesta : 0),["class" => "select form-control", "placeholder" =>"Seleccione" ,'onchange'=>'cargarEntrevista(this.value);'])!!}
                                         </div>
                                         <div id="encuestas">
                                         <?php
                                          if(isset($textohtml))
                                          { 
                                              echo $textohtml;
                                          }
                                          ?>
                                         </div>
                                        </div>

                        </div>

  </div>
                                     @if(isset($entrevista))
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

    


<script>

 CKEDITOR.replace(('estudioActualEntrevistaPregunta','horarioEstudioEntrevistaPregunta','motivacionCarreraEntrevistaPregunta','expectativaEstudioEntrevistaPregunta','expectativaLaboralEntrevistaPregunta','motivacionTrabajoEntrevistaPregunta','proyeccion5AñosEntrevistaPregunta','tiempoLibreEntrevistaPregunta','introvertidoEntrevistaPregunta','vicioEntrevistaPregunta','antecedentesEntrevistaPregunta','anecdotaEntrevistaPregunta','observacionEntrevistaPregunta'), {
        fullPage: true,
        allowedContent: true
      }); 
 $(document).ready( function () {

  $("#fechaEntrevista").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );

 $("#EntrevistaFechaNacimiento").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );
});

  $("#fechaNacimientoEntrevistaPregunta").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );
 
</script> 

   
   @stop
