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
                        
<script>

valorCumple = Array("No Aplica","Parcial","Total");
NombreCumple = Array ("No Aplica","Parcial","Total");
Cumplimiento = [valorCumple,NombreCumple];

//VARIABLES
    

 $(document).ready( function () {

// // multiregistro Educacion Entrevista primera Multiregistro

          
          Educacionentrevista = new Atributos('Educacionentrevista','EducacionEntrevista_Modulo','Educaciondescripcion_');

          Educacionentrevista.campoid = 'idEntrevistaEducacion';  //hermanitas             
          Educacionentrevista.campoEliminacion = 'eliminarEducacionEntrevista';//hermanitas         Cuando se utilice la funcionalidad 
          Educacionentrevista.botonEliminacion = true;//hermanitas
          // despues del punto son las propiedades que se le van adicionar al objeto
          Educacionentrevista.campos = ['idEntrevistaEducacion','nombreEducacion','PerfilCargo_idRequerido','PerfilCargo_idAspirante','calificacionEntrevistaEducacion','Entrevista_idEntrevista']; //[arrays ]
          Educacionentrevista.altura = '35px;'; 
           // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          Educacionentrevista.etiqueta = ['input','input','input','input','input','input'];
          Educacionentrevista.tipo = ['hidden','hidden','hidden','text','hidden','text']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          Educacionentrevista.estilo =  ['', '', 'width: 600px;height:35px;background-color:#EEEEEE; ','width: 100px;height:35px;background-color:#EEEEEE;','','width: 300px;height:35px;']; 

          // estas propiedades no son muy usadas PERO SON UTILES
          
          Educacionentrevista.clase = ['','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          Educacionentrevista.sololectura = [false,false,true,true,true,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          Educacionentrevista.completar = ['off','off','off','off','off','off']; //autocompleta 
          
          Educacionentrevista.opciones = ['','','','','','']; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          Educacionentrevista.funciones  = ['','','','','','']; // cositas mas especificas , ejemplo ; vaya a  propiedad etiqueta y cuando escriba referencia  trae la funcion  


// // multiregistro Formacionentrevista Entrevista primera Multiregistro

        
          // Formacionentrevista = new Atributos('Formacionentrevista','FormacionEntrevista_Modulo','Formacionentrevistaciondescripcion_');

          // Formacionentrevista.campoid = 'idEntrevistaFormacion';  //hermanitas             
          // Formacionentrevista.campoEliminacion = 'eliminarFormacionEntrevista';//hermanitas         Cuando se utilice la funcionalidad 
          // Formacionentrevista.botonEliminacion = true;//hermanitas
          // // despues del punto son las propiedades que se le van adicionar al objeto
          // Formacionentrevista.campos = ['idEntrevistaFormacion','PerfilCargo_idRequerido','PerfilCargo_idAspirante','Entrevista_idEntrevista','nombreEducacion','calificacionEntrevistaFormacion',]; //[arrays ]
          // Formacionentrevista.altura = '35px;'; 
          //  // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          // Formacionentrevista.etiqueta = ['input','input','input','input','select','select'];
          // Formacionentrevista.tipo = ['hidden','hidden','hidde','text','','']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          // Formacionentrevista.estilo = ['', '', 'width: 600px;height:35px;background-color:#EEEEEE; ','width: 100px;height:35px;background-color:#EEEEEE;','width: 300px;height:35px;','width: 300px;height:35px;']; 

          // // estas propiedades no son muy usadas PERO SON UTILES
          
          // Formacionentrevista.clase = ['','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          // Formacionentrevista.sololectura = [false,false,true,true,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          // Formacionentrevista.completar = ['off','off','off','off','off','off']; //autocompleta 
          
          // Formacionentrevista.opciones = ['','','','','',Cumplimiento]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          // Formacionentrevista.funciones  = ['','','','','',''];




// // multiregistro  Hijos Conyugue 

        
          // entrevistapreguntahijos = new Atributos('Formacionentrevista','FormacionEntrevista_Modulo','Formacionentrevistaciondescripcion_');

          // Formacionentrevista.campoid = 'idEntrevistaFormacion';  //hermanitas             
          // Formacionentrevista.campoEliminacion = 'eliminarFormacionEntrevista';//hermanitas         Cuando se utilice la funcionalidad 
          // Formacionentrevista.botonEliminacion = true;//hermanitas
          // // despues del punto son las propiedades que se le van adicionar al objeto
          // Formacionentrevista.campos = ['idEntrevistaFormacion','PerfilCargo_idRequerido','PerfilCargo_idAspirante','Entrevista_idEntrevista','nombreEducacion','calificacionEntrevistaFormacion',]; //[arrays ]
          // Formacionentrevista.altura = '35px;'; 
          //  // correspondiente en el mismo orden del mismo array , no puede tener mas campos que los que esten definidos
          // Formacionentrevista.etiqueta = ['input','input','input','input','select','select'];
          // Formacionentrevista.tipo = ['hidden','hidden','hidde','text','','']; //tipo hidden - oculto para el usuario  y los otros quedan visibles ''
          // Formacionentrevista.estilo = ['', '', 'width: 600px;height:35px;background-color:#EEEEEE; ','width: 100px;height:35px;background-color:#EEEEEE;','width: 300px;height:35px;','width: 300px;height:35px;']; 

          // // estas propiedades no son muy usadas PERO SON UTILES
          
          // Formacionentrevista.clase = ['','','','','',''];  //En esta propiedad se puede utilizar las clases , pueden ser de  boostrap  ejm: from-control o clases propias
          // Formacionentrevista.sololectura = [false,false,true,true,false,false]; //es para que no le bloquee el campo al usuario para que este pueda digitar de lo contrario true 
          // Formacionentrevista.completar = ['off','off','off','off','off','off']; //autocompleta 
          
          // Formacionentrevista.opciones = ['','','','','',Cumplimiento]; // se utiliza cuando las propiedades de la etiqueta son tipo select 
          // Formacionentrevista.funciones  = ['','','','','',''];

        });






</script> 



<div id='form-section' >

  <fieldset id="entrevista-form-fieldset">  

                                      <!-- Cedula aspirante -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('documentoAspiranteEntrevista', 'Cedula', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('documentoAspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Cedula', 'autocomplete' => 'off'])!!}
                                                 {!!Form::hidden('Tercero_idAspirante ', null, array('id' => 'Tercero_idAspirante ')) !!} 
                                            </div>
                                          </div>
                                      </div>
                                            <!-- Estado Final -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('estadoEntrevista ', 'Estado Final', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-bars "></i>
                                              </span>

                                            {!! Form::select('estadoEntrevista', ['En Proceso' =>'En Proceso','Seleccionado' => 'Seleccionado','Rechazado'=>'Rechazado'],null,['class' => 'form-control',"placeholder"=>"Seleccione el estado"]) !!}                                     

                                            </div>
                                          </div>
                                      </div>

                                              <!-- Cargo -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('Cargo_idCargo ', 'Cargo', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-bars "></i>
                                              </span>
                                          {!!Form::select('Cargo_idCargo',$cargo, (isset($entrevista) ? $entrevista->Cargo_idCargo : 0),["class" => "select form-control", "placeholder" =>"Seleccione", 'onchange'=>'llenarFormacionCargo,llenarEducacionCargo(this.value)'])!!}
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
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('nombre1AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su Nombre', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>


                                              <!-- Nombre 2 aspirante -->
                                    <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('nombre2AspiranteEntrevista', 'Nombre2', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('nombre2AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su segundo Nombre', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>



                                        
                                                  <!-- Apellido 1 aspirante -->
                                    <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('apellido1AspiranteEntrevista', 'Apellido1', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('apellido1AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su primer apellido', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>

                                               <!-- Apellido 2 aspirante -->
                                    <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('apellido2AspiranteEntrevista', 'Apellido2', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('apellido2AspiranteEntrevista',null,['class'=>'form-control','placeholder'=>'Ingrese su segundo apellido', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>

                                             <!--  Entrevistador --> 
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('nombreEntrevistadorEntrevista', 'Entrevistador', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-bars "></i>
                                              </span>
                                                {!!Form::select('Tercero_idEntrevistador',$Tercero, (isset($entrevista) ? $entrevista->Tercero_idEntrevistador : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                            </div>
                                          </div>
                                      </div>

                                        <!-- Fecha Entrevista -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('fechaEntrevista ', 'F.Entrevista ', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('fechaEntrevista ',null,['class'=>'form-control','placeholder'=>'Fecha Entrevista', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>


                                       <!-- Experiencia en Años -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('experienciaAspiranteEntrevista ', 'Exp(Años)', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('experienciaAspiranteEntrevista ',null,['class'=>'form-control','placeholder'=>'Ingrese su Experiencia en Años', 'autocomplete' => 'off'])!!}
                                            </div>
                                          </div>
                                      </div>


                                           <!-- Requerida -->
                                      <div class="form-group col-md-6" id='test'>
                                          {!!Form::label('experienciaRequeridaEntrevista ', 'Exp.Requerida', array('class' => 'col-sm-2 control-label')) !!}
                                          <div class="col-sm-8">
                                            <div class="input-group">
                                              <span class="input-group-addon">
                                                <i class="fa fa-user "></i>
                                              </span>
                                              {!!Form::text('experienciaAspiranteEntrevista ',2,['class'=>'form-control','readonly','placeholder'=>'', 'autocomplete' => 'off'])!!}
                                              
                                            </div>
                                          </div>
                                     </div>                          
            </fieldset>                                                 
 </div>
 <input type="hidden" id="token" value="{{csrf_token()}}"/>
                                              <!-- OPCIONES DEL FORMULARIO  -->  

                                        
                            <ul class="nav nav-tabs"> <!--Pestañas de navegacion 4 opciones-->

                              <li class="active"><a data-toggle="tab"  onclick="mostrarDivGenerales('General')" href="#General">General</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Competencias')" href="#Competencias">Competencias</a></li>
                              <li class=""><a data-toggle="tab"  onclick="mostrarDivGenerales('Habilidades')" href="#Habilidades">Habilidades</a></li>
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
                                                                  <div class="col-md-1" style="width:40px;height: 35px; cursor:pointer;">
                                                                          <span class="glyphicon glyphicon-plus"></span>
                                                                        </div>
                                                                  <div class="col-md-1" style="width: 600px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                 <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                 <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>

                                                                 <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Cumple </div>

                                                                
                                                                  <!-- este es el div para donde van insertando los registros --> 
                                                                  <div id="EducacionEntrevista_Modulo">
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
                                                                  <div class="col-md-1" style="width:40px;height: 35px; cursor:pointer;">
                                                                          <span class="glyphicon glyphicon-plus"></span>
                                                                        </div>
                                                                  <div class="col-md-1" style="width: 600px;display:inline-block;height:35px;">Requerida por el Cargo</div>

                                                                 <div class="col-md-1" style="width: 100px;display:inline-block;height:35px;">% Peso</div>


                                                                 <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Competencia del Empleado</div>
                                                                <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Cumple </div>
                                                                
                                                                  <!-- este es el div para donde van insertando los registros --> 
                                                                  <div id="FormacionEntrevista_Modulo">
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div> 
                                                    </div>
                                                  </div>
                                                </div>  
                                                <!-- S -->

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
                                               
                                            <!-- OPCION DATOS PERSONALES -->
                               <div id="aspectopersonal" class="tab-panel fade in active" >
                                 <div class="entrevista-container">
                                     <div class="panel panel-default" > 

                                                 <!-- Telefono  --> 
                                                                <div class="form-group">
                                                                    <div class="panel-body">
                                                                        <div class="form-group" id='test'>
                                                                             {!!Form::label('telefonoEntrevistaPregunta', 'Telefono', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-5 ">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('telefonoEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su telefono'])!!}
                                                                                 </div>
                                                                            </div>

                                                                            <div class="form-group" id='test'>
                                                                             {!!Form::label('movilEntrevistaPregunta', 'Mòvil', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-3">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('movilEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Movil'])!!}
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
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('correoElectronicoEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Correo Electronico'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>

                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('direccionEntrevistaPregunta', 'Direccion', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-10">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('direccionEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Direccion'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>

                                                                         <div class="form-group" id='test'>
                                                                             {!!Form::label('Ciudad_idResidencia', 'Ciudad', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-10">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-bars"></i>
                                                                                     </span>
                                                                {!!Form::select('Ciudad_idResidencia',$Ciudad, (isset($entrevista) ? $entrevista->Ciudad_idResidencia : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>
                                                                    

                                                                 </br>
                                                                
                                                              


                                                                    <!-- DATOS DEL CONYUGUE  -->
                                                                    
                                          <font color = "000000">Datos del Conyuge</font> 
                                        
                                                                                   <!-- nombreConyugeEntrevistaPregunta  -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('nombreConyugeEntrevistaPregunta', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-10">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('nombreConyugeEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Nombre'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>
                                                                                        <!-- Ocupacion conyugue -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('ocupacionConyugeEntrevistaPregunta', 'Ocupacion', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-10">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('ocupacionConyugeEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Ocupación'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>
                                                                                       <!--  Numero de Hijos Conyugue -->
                                                                         <div class="form-group" id='test'>
                                                                             {!!Form::label('numeroHijosEntrevistaPregunta', 'Número Hijos', array('class' => 'col-sm-2 control-label')) !!}
                                                                            <div class="col-sm-10">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('numeroHijosEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese Número de Hijos'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>

                                                                                <!-- MULTIREGISTRO HIJOS  -->
                                                            
                                                                        <div class="form-group" id='test'>
                                                                            <div class="col-sm-12">

                                                                              <div class="row show-grid">
                                                                                <div class="col-md-1" style="width: 40px;height: 35px;" onclick="competencia.agregarCampos(competenciamodelo,'A')">
                                                                                  <span class="glyphicon glyphicon-plus"></span>
                                                                                </div>
                                                                                <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Nombre</div>
                                                                                <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Edad</div>
                                                                                <div class="col-md-1" style="width: 300px;display:inline-block;height:35px;">Ocupación</div>
                                                                               
                                                                                  

                                                                                <!-- este es el div para donde van insertando los registros --> 
                                                                                <div id="competencia_Modulo">
                                                                                </div>
                                                                                 </div>
                                                                            </div>
                                                                        </div>  
                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                         
                                                                        <!-- Con quien vive   -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('conQuienViveEntrevistaPregunta', 'Vive Con', array('class' => 'col-sm-1 control-label')) !!}
                                                                            <div class="col-sm-11">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('conQuienViveEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese Con quien Vive'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>
                                                                            </br>
                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                          </br>
                                                                          </br>
          
                                                                                        <!--  Donde Vive -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('dondeViveEntrevistaPregunta', ' DondeVive', array('class' => 'col-sm-1 control-label')) !!}
                                                                            <div class="col-sm-11">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('dondeViveEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese Donde Vive'])!!}
                                                                                 </div>
                                                                            </div>

                                                                         </div>

                                                                        </br>
                                                                          </br>
                                                                      
                                                                                       <!--  Ocupacion Actual -->
                                                                         <div class="form-group" id='test'>
                                                                             {!!Form::label('ocupacionActualEntrevistaPregunta', 'Ocupación', array('class' => 'col-sm-1 control-label')) !!}
                                                                            <div class="col-sm-11">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('ocupacionActualEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese su Ocupación actual'])!!}
                                                                                 </div>

                                                                            </div>

                                                                         </div>
                                                                          </br>
                                                                          </br>
                                                                           </br>
                                                                          </br>
                                                                  <font color = "000000">Como es su Relacion con</font>
                                                                    </br>
                                                                          </br>
                                                                          <!-- ESTOS DATOS HAY QUE PEDIRCELOS A ANDRES FALTAN! -->
                                                                                    <!--  Padre -->
                                                                  <div class="form-group col-md-6" id='test'>
                                                                      {!!Form::label('documentoAspiranteEntrevista', 'Padre', array('class' => 'col-sm-2 control-label')) !!}
                                                                      <div class="col-sm-10">
                                                                        <div class="input-group">
                                                                          <span class="input-group-addon">
                                                                            <i class="fa fa-bars "></i>
                                                                          </span>
                                                                          {!! Form::select('estadoEntrevista', ['Distante' =>'Distante','Normal' => 'Normal','Amistosa'=>'Amistosa','NoExiste'=>'NoExiste'],null,['class' => 'form-control',"placeholder"=>"Seleccione "]) !!}  
                                                                        </div>
                                                                      </div>
                                                                  </div>
                                                                                    <!--  Madre -->
                                                                  <div class="form-group col-md-6" id='test'>
                                                                      {!!Form::label('documentoAspiranteEntrevista', 'Madre', array('class' => 'col-sm-2 control-label')) !!}
                                                                      <div class="col-sm-10">
                                                                        <div class="input-group">
                                                                          <span class="input-group-addon">
                                                                            <i class="fa fa-bars "></i>
                                                                          </span>
                                                                          {!! Form::select('estadoEntrevista', ['Distante' =>'Distante','Normal' => 'Normal','Amistosa'=>'Amistosa','NoExiste'=>'NoExiste'],null,['class' => 'form-control',"placeholder"=>"Seleccione "]) !!}   
                                                                        </div>
                                                                      </div>
                                                                  </div>
                                                                                <!--  Hermanos -->
                                                                    <div class="form-group col-md-6" id='test'>
                                                                      {!!Form::label('documentoAspiranteEntrevista', 'Hermanos', array('class' => 'col-sm-2 control-label')) !!}
                                                                      <div class="col-sm-10">
                                                                        <div class="input-group">
                                                                          <span class="input-group-addon">
                                                                            <i class="fa fa-bars "></i>
                                                                          </span>
                                                                          {!! Form::select('estadoEntrevista', ['Distante' =>'Distante','Normal' => 'Normal','Amistosa'=>'Amistosa','NoExiste'=>'NoExiste'],null,['class' => 'form-control',"placeholder"=>"Seleccione "]) !!}  
                                                                        </div>
                                                                      </div>
                                                                  </div>
                                                                               <!--  Conyuge -->
                                                           <div class="form-group col-md-6" id='test'>
                                                              {!!Form::label('documentoAspiranteEntrevista', 'Conyuge', array('class' => 'col-sm-2 control-label')) !!}
                                                              <div class="col-sm-10">
                                                                <div class="input-group">
                                                                  <span class="input-group-addon">
                                                                    <i class="fa fa-bars "></i>
                                                                  </span>
                                                                  {!! Form::select('estadoEntrevista', ['Distante' =>'Distante','Normal' => 'Normal','Amistosa'=>'Amistosa','NoExiste'=>'NoExiste'],null,['class' => 'form-control',"placeholder"=>"Seleccione "]) !!}   
                                                                </div>
                                                              </div>
                                                          </div> 

                                                          <!-- Hijos -->

                                                             <div class="form-group col-md-6" id='test'>
                                                              {!!Form::label('documentoAspiranteEntrevista', 'Hijos', array('class' => 'col-sm-2 control-label')) !!}
                                                              <div class="col-sm-10">
                                                                <div class="input-group">
                                                                  <span class="input-group-addon">
                                                                    <i class="fa fa-bars "></i>
                                                                  </span>
                                                                   {!! Form::select('estadoEntrevista', ['Distante' =>'Distante','Normal' => 'Normal','Amistosa'=>'Amistosa','NoExiste'=>'No Existe'],null,['class' => 'form-control',"placeholder"=>"Seleccione "]) !!}  
                                                                </div>
                                                              </div>
                                                          </div>
                                          </div>
                                 </div>  

                                                                                
                                           </div>
                                    </div>
                               </div>
                                              <!-- educativos -->
                                <div id="educativo" class="tab-panel fade" >
                                    <div class="educativo-container">
                                          <div class="panel panel-default" > 

                                                   <!-- Estudia Actualmente -->
                                                  
                                                    <div class="panel-body">
                                                     <font color = "000000">Estudia Actualmente </font>
                                                    <div class="form-group" id='test'>
                                                          <div class="col-sm-10" style="width: 100%;">
                                                            <div class="input-group">
                                                              {!!Form::textarea('estudioActualEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'Ingresa la convocatoria'])!!}
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
                                                              {!!Form::textarea('horarioEstudioEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'Cual es su horario de Estudio'])!!}
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
                                                              {!!Form::textarea('motivacionCarreraEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
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
                                                              {!!Form::textarea('expectativaEstudioEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'motivacionCarreraEntrevistaPregunta'])!!}
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>



                                                                                        
                                                                  



                                                                      
                                           </div>
                                     </div>
                               </div>
                                          <!-- laborales -->
                                <div id="laboral" class="tab-panel fade" >
                                    <div class="entrevista-container">
                                      <div class="panel panel-default" > 

                                               <!-- Ultimo empleo -->
                                                  
                                                    <div class="panel-body">
                                                     <font color = "000000">Cual fue el Último Empleo que tuvo?</font>
                                                    <div class="form-group" id='test'>
                                                          <div class="col-sm-10" style="width: 100%;">
                                                            <div class="input-group">
                                                              {!!Form::textarea('ultimoEmpleoEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'Cual fue el Último Empleo que tuvo?'])!!}
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
                                                              {!!Form::textarea('funcionesEmpleoEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'Digite sus Funciones Principales'])!!}
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
                                                              {!!Form::textarea('logrosEmpleoEntrevistaPregunta',null,['class'=>'ckeditor','placeholder'=>'Digite los logros Obtenidos'])!!}
                                                            </div>
                                                          </div>
                                                        </div>

                                                      </div>



      
                                                                                
                                    
                                                                <!-- PARA CAMBIARRRRRRRRRRRRRRRRRRRRRRRTERETREEH   -->
                                                                          <div class="form-group" id='test'>
                                                                             {!!Form::label('conQuienViveEntrevistaPregunta', 'Vive Con', array('class' => 'col-sm-1 control-label')) !!}
                                                                            <div class="col-sm-11">
                                                                              <div class="input-group">
                                                                                     <span class="input-group-addon">
                                                                                            <i class="fa fa-user"></i>
                                                                                     </span>
                                                                                         {!!Form::text('conQuienViveEntrevistaPregunta',null,['class'=> 'form-control','placeholder'=>'Por favor Ingrese Con quien Vive'])!!}
                                                                                 </div>
                                                                            </div>
                                                                         </div>
                                     </div>
                                       </div>   
                               </div>
                                            <!-- socialespersonalidad -->
                                 <div id="sociales" class="tab-panel fade" >
                                 <div class="entrevista-container">
                                     <div class="panel panel-default" > 

                                                  socialespersonalidad     
                                                                                
                                           </div>
                                     </div>
                               </div>
                               

                            
                                      
                                                                                        </br>                                            
                                   
      
                                      
</div>
     <!-- OPCION 3 -->
                                         <div id="Habilidades" class="tab-pane fade">
                                      
                                        asdasda
                                        </div>

                                                     <!--  OOPCION 4 -->
                                       <div id="otraspreguntas" class="tab-pane fade">
                                         asdasd
                                        </div>
                                     @if(isset($entrevista))
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

    


<script>

 CKEDITOR.replace(('estudioActualEntrevistaPregunta','horarioEstudioEntrevistaPregunta','motivacionCarreraEntrevistaPregunta','expectativaEstudioEntrevistaPregunta','','',''), {
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







 
</script> 

   
   @stop
 