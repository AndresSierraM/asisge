@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Plan de Emergencias</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::style('css/signature-pad.css'); !!} 
{!!Html::style('css/image-pad.css'); !!} 


<?php
  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  $base64 = ''; 
  if(isset($planemergencia))
  {
    $path = 'imagenes/'.$planemergencia["firmaRepresentantePlanEmergencia"];
    
    if($planemergencia["firmaRepresentantePlanEmergencia"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
  }
?> 



  <script>
  // Se recibe la consulta de la multigistro para que muestre los datos de los campos en multi limite
   var PlanEmergenciaLimiteDetalle = '<?php echo (isset($PlanEmergenciaLimite) ? json_encode($PlanEmergenciaLimite) : "");?>';
  PlanEmergenciaLimiteDetalle = (PlanEmergenciaLimiteDetalle != '' ? JSON.parse(PlanEmergenciaLimiteDetalle) : '');
// Se recibe la consulta de la multigistro para que muestre los datos de los campos en multi Inventario
    var PlanEmergenciaIventarioDetalle = '<?php echo (isset($PlanEmergenciaInventario) ? json_encode($PlanEmergenciaInventario) : "");?>';
  PlanEmergenciaIventarioDetalle = (PlanEmergenciaIventarioDetalle != '' ? JSON.parse(PlanEmergenciaIventarioDetalle) : '');

// Datos para mutiregistro Limite
var LimiteDatos = ['','','','','','',''];
// Datos para mutiregistro Inventario
var InventarioDatos = ['','','','','','',''];
$(document).ready(function(){
                                                              // MULTIREGISTRO LIMITE
      limite = new Atributos('limite','limite_detalle','detalle_');
      limite.altura = '36px;';
      limite.campoid = 'idPlanEmergenciaLimite';
      limite.campoEliminacion = 'eliminarlimite';
      limite.botonEliminacion = true;
      limite.campos = ['idPlanEmergenciaLimite','PlanEmergencia_idPlanEmergencia','sedePlanEmergenciaLimite','nortePlanEmergenciaLimite', 'surPlanEmergenciaLimite','orientePlanEmergenciaLimite','occidentePlanEmergenciaLimite'];
      limite.etiqueta = ['input','input','input','input','input','input','input'];
      limite.tipo = ['hidden','hidden','text','text','text','text','text'];
      limite.estilo = ['','','width: 180px;height:35px;','width: 180px;height:35px;','width: 180px;height:35px;','width: 180px;height:35px;','width: 180px;height:35px;'];
      limite.clase = ['','','','','','',''];
      limite.sololectura = [false,false,false,false,false,false,false];
      limite.opciones = ['','','','','','',''];
      var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
      limite.funciones = ['','',quitacarac,quitacarac,quitacarac,quitacarac,quitacarac];

                                                                 // MULTIREGISTRO Inventario
      inventario = new Atributos('inventario','Inventario_detalle','detalle_');
      inventario.altura = '36px;';
      inventario.campoid = 'idPlanEmergenciaInventario';
      inventario.campoEliminacion = 'eliminarInventario';
      inventario.botonEliminacion = true;
      inventario.campos = ['idPlanEmergenciaInventario','PlanEmergencia_idPlanEmergencia','sedePlanEmergenciaInventario','recursoPlanEmergenciaInventario', 'cantidadPlanEmergenciaInventario','ubicacionPlanEmergenciaInventario','observacionPlanEmergenciaInventario'];
      inventario.etiqueta = ['input','input','input','input','input','input','input'];
      inventario.tipo = ['hidden','hidden','text','text','text','text','text'];
      inventario.estilo = ['','','width: 180px;height:35px;','width: 180px;height:35px;','width: 180px;height:35px;','width: 180px;height:35px;','width: 180px;height:35px;'];
      inventario.clase = ['','','','','','',''];
      inventario.sololectura = [false,false,false,false,false,false,false];
      inventario.opciones = ['','','','','','',''];
      var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
      inventario.funciones = ['','',quitacarac,quitacarac,quitacarac,quitacarac,quitacarac];


      // For para llenar los registros al momento de modificar el registro Limite
      for(var j=0, k = PlanEmergenciaLimiteDetalle.length; j < k; j++)
      {       
        limite.agregarCampos(JSON.stringify(PlanEmergenciaLimiteDetalle[j]),'L');       
      }

        // For para llenar los registros al momento de modificar el registro Inventario
      for(var j=0, k = PlanEmergenciaIventarioDetalle.length; j < k; j++)
      {       
        inventario.agregarCampos(JSON.stringify(PlanEmergenciaIventarioDetalle[j]),'L');       
      }


    });

  </script>

	@if(isset($planemergencia))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($planemergencia,['route'=>['planemergencia.destroy',$planemergencia->idPlanEmergencia],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($planemergencia,['route'=>['planemergencia.update',$planemergencia->idPlanEmergencia],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'planemergencia.store','method'=>'POST', 'files' => true])!!}
	@endif

<div id="signature-pad" class="m-signature-pad">
  <input type="hidden" id="signature-reg" value="">
    <div class="m-signature-pad--body">
      <canvas></canvas>
    </div>
    <div class="m-signature-pad--footer">
      <div class="description">Firme sobre el recuadro</div>
      <button type="button" class="button clear btn btn-danger" data-action="clear">Limpiar</button>
      <button type="button" class="button save btn btn-success" data-action="save">Guardar Firma</button>
    </div>
</div>


<div id="image-pad" class="m-image-pad" style="display: none;">
    <input type="hidden" id="image-reg" value="">
      <div class="m-image-pad--body">
        <img id="image-src"></img>
      </div>
      <div class="m-image-pad--footer">
        <div class="description">Vista previa de la imagen</div>
        <button type="button" class="button clear btn btn-primary" onclick="document.getElementById('image-pad').style.display = 'none';">Cerrar</button>
      </div>
</div>



<div id='form-section' >

	<fieldset id="inspeccion-form-fieldset">
           <div class="form-group required" id='test'>
                {!!Form::label('nombrePlanEmergencia', 'Nombre ', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <div class="input-group"> 
                        <span class="input-group-addon">
                          <i class="fa fa-pencil-square-o" style="width: 14px";></i>
                          </span>
                    {!!Form::text('nombrePlanEmergencia',null,['class'=>'form-control','placeholder'=>'Por favor ingrese su Nombre',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
                    {!!Form::hidden('idPlanEmergencia', 0, array('id' => 'idPlanEmergencia'))!!}
                     {!!Form::hidden('eliminarlimite',null, array('id' => 'eliminarlimite'))!!}
                     {!!Form::hidden('eliminarInventario',null, array('id' => 'eliminarInventario'))!!}                     
                                                                  
                    </div>
                 </div>
            </div>
            <div class="form-group required" id='test'>
                {!!Form::label('fechaElaboracionPlanEmergencia', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
                <div class="col-sm-10" >
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar" ></i>
                    </span>
                    {!!Form::text('fechaElaboracionPlanEmergencia',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
                  </div>
                </div>
                    <!-- Nuevo Campo Centro de Costos  -->
                <div class="form-group">
                        {!!Form::label('CentroCosto_idCentroCosto', 'Centro de Costos', array('class' => 'col-sm-2 control-label'))!!}
                      <div class="col-sm-10" ">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <i class="fa fa-university" style="width: 14px;"></i>
                          </span>
                          {!!Form::select('CentroCosto_idCentroCosto',$centrocosto, (isset($planemergencia) ? $planemergencia->CentroCosto_idCentroCosto : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}                    
                        </div>
                      </div>
                </div>
                <div class="form-group required" id='test'>
                  {!!Form::label('Tercero_idRepresentanteLegal', 'Realizada Por', array('class' => 'col-sm-2 control-label'))!!}       
                  <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-flag"></i>
                        </span>
                      {!!Form::select('Tercero_idRepresentanteLegal',$tercero, (isset($planemergencia) ? $planemergencia->Tercero_idRepresentanteLegal : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tercero de quien realiza el Plan de Emergencia"])!!}
                      <div class="col-sm-10">
                        <img id="firma" style="width:200px; height: 150px; border: 1px solid;" onclick="mostrarFirma();" src="<?php echo $base64;?>">
                        {!!Form::hidden('firmabase64', $base64, array('id' => 'firmabase64'))!!}
                      </div>
                    </div>
                  </div>
                </div>
            </div>
    
        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Detalles</div>
                <div class="panel-body">
                  <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                         <!-- Acordeon  justificacion-->
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#justificacion">Justificaci&oacute;n</a>
                        </h4>
                      </div>
                      <div id="justificacion" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('justificacionPlanEmergencia',null,['class'=>'form-control','placeholder'=>'Ingrese la Justificaci&oacute;n'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Acordeon Marco Legal -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#marcolegal">Marco Legal</a>
                        </h4>
                      </div>
                      <div id="marcolegal" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('marcoLegalPlanEmergencia',null,['class'=>'form-control','placeholder'=>'Ingrese El Marco Legal'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <!-- Acordeon Definiciones -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Definiciones">Definiciones</a>
                        </h4>
                      </div>
                      <div id="Definiciones" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('definicionesPlanEmergencia',null,['class'=>'form-control','placeholder'=>'Ingrese la Definici&oacute;n'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <!-- Acordeon Generalidades -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Generalidades">Generalidades</a>
                        </h4>
                      </div>
                      <div id="Generalidades" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('generalidadesPlanEmergencia',null,['class'=>'form-control','placeholder'=>'Ingrese las Generalidades'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Acordeon Objetivos -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Objetivos">Objetivos</a>
                        </h4>
                      </div>
                      <div id="Objetivos" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('objetivosPlanEmergencia',null,['class'=>'form-control','placeholder'=>'Ingrese los objetivos'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <!-- Acordeon Alcance -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Alcance">Alcance</a>
                        </h4>
                      </div>
                      <div id="Alcance" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('alcancePlanEmergencia',null,['class'=>'form-control','placeholder'=>'Ingrese el Alcance'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <!-- Acordeon Informacion de la Empresa -->
                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#infoempresa">Información de la Empresa</a>
                        </h4>
                      </div>
                      <div id="infoempresa" class="panel-collapse collapse">
                        <div class="panel-body" style="height: 100%">
                                                             <!--NIT  -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('nitPlanEmergencia', 'Nit', array('class' => 'col-sm-2 control-label','style'=>'width:190px;'))!!}
                              <div class="col-sm-10" style="width:390px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('nitPlanEmergencia',(isset($planemergencia) ? $planemergencia->nitPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese el Nit','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>
                                                           <!--Direccion  -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('direccionPlanEmergencia', 'Direcci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:160px;'))!!}
                              <div class="col-sm-10" style="width:350px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-home" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('direccionPlanEmergencia',(isset($planemergencia) ? $planemergencia->direccionPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese la Direcci&oacute;n','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>

                                                            <!--tel&#233;fono  -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('telefonoPlanEmergencia', 'Tel&#233;fono', array('class' => 'col-sm-2 control-label','style'=>'width:190px;'))!!}
                              <div class="col-sm-10" style="width:390px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-phone" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('telefonoPlanEmergencia',(isset($planemergencia) ? $planemergencia->telefonoPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese el Tel&#233;fono','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>
                                                             <!--ubicacion -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('ubicacionPlanEmergencia', 'Ubicaci&oacute;n', array('class' => 'col-sm-2 control-label','style'=>'width:160px;'))!!}
                              <div class="col-sm-10" style="width:350px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-location-arrow" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('ubicacionPlanEmergencia',(isset($planemergencia) ? $planemergencia->ubicacionPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese la ubicaci&oacute;n','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div> 
                                                          <!--numero de personal Operativo -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('personalOperativoPlanEmergencia', 'N&#250;mero de Personal operativo', array('class' => 'col-sm-2 control-label','style'=>'width:190px;'))!!}
                              <div class="col-sm-10" style="width:390px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('personalOperativoPlanEmergencia',(isset($planemergencia) ? $planemergencia->personalOperativoPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese el número de Personal Operativo','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div> 
                                                               <!--N&#250;mero Personal Administrativo -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('personalAdministrativoPlanEmergencia', 'N&#250;mero Personal Administrativo', array('class' => 'col-sm-2 control-label','style'=>'width:160px;'))!!}
                              <div class="col-sm-10" style="width:350px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('personalAdministrativoPlanEmergencia',(isset($planemergencia) ? $planemergencia->ubicacionPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese el número de Personal Administrativo','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>
                            <br><br><br><br><br><br>
                                                              <!--Turno del Personal Operativo  -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('turnoOperativoPlanEmergencia', 'Turno del Personal Operativo', array('class' => 'col-sm-2 control-label','style'=>'width:190px;'))!!}
                              <div class="col-sm-10" style="width:390px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-list-ol" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('turnoOperativoPlanEmergencia',(isset($planemergencia) ? $planemergencia->turnoOperativoPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese el Turno del personal operativo','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>
                                                            <!--Turno Personal Administrativo -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('turnoAdministrativoPlanEmergencia', 'Turno Personal Administrativo', array('class' => 'col-sm-2 control-label','style'=>'width:160px;'))!!}
                              <div class="col-sm-10" style="width:350px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-list-ol" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('turnoAdministrativoPlanEmergencia',(isset($planemergencia) ? $planemergencia->turnoAdministrativoPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese eñ Turno del Personal  Administrativo','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>
                             <br><br><br>
                                                             <!--N&#250;mero de Visitas Diarias en Promedio -->
                            <div class="form-group" style="width:600px; display: inline;">
                              {!!Form::label('visitasDiaPlanEmergencia', 'N&#250;mero de Visitas Diarias en Promedio', array('class' => 'col-sm-2 control-label','style'=>'width:190px;'))!!}
                              <div class="col-sm-10" style="width:390px;">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-users" style="width: 14px;"></i>
                                  </span>
                                  {!!Form::text('visitasDiaPlanEmergencia',(isset($planemergencia) ? $planemergencia->visitasDiaPlanEmergencia : null),['class'=>'form-control','placeholder'=>'Ingrese el N&#250;mero de visitas diarias en Promedio','style'=>'width:340px;'])!!}
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <!-- Acordeon limites Geofraficos -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#limites">limites geogr&#225;ficos</a>
                        </h4>
                      </div>
                      <div id="limites" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group" id='test'>
                                <div class="col-sm-12">

                                  <div class="row show-grid">
                                    <div class="col-md-1" style="width: 40px;height: 35px;" onclick="limite.agregarCampos(LimiteDatos,'A')">
                                      <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Sede</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Norte</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Sur</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Oriente</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Occidente</div>
                                      

                                    <!-- este es el div para donde van insertando los registros --> 
                                    <div id="limite_detalle">
                                    </div>
                                  </div>
                                </div>
                            </div>                      
                        </div>
                    </div>
                  </div>
                      <!-- Acordeon limites Geofraficos -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#inventario">Inventario de recursos Físicos</a>
                        </h4>
                      </div>
                      <div id="inventario" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group" id='test'>
                                <div class="col-sm-12">

                                  <div class="row show-grid">
                                    <div class="col-md-1" style="width: 40px;height: 35px;" onclick="inventario.agregarCampos(InventarioDatos,'A')">
                                      <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Sede</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Recurso</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Cantidad</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Ubicaci&oacute;n</div>
                                    <div class="col-md-1 requiredMulti" style="width: 180px;display:inline-block;height:35px;">Observaciones</div>
                                      

                                    <!-- este es el div para donde van insertando los registros --> 
                                    <div id="Inventario_detalle">
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

      
    </fieldset>
	@if(isset($planemergencia))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
      @else
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'habilitarSubmit(event);'])!!}
  @endif
  
  

	{!! Form::close() !!}

  </div>
</div>


  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
    
    $('#fechaElaboracionPlanEmergencia').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    CKEDITOR.replace(('justificacionPlanEmergencia'), {
        fullPage: true,
        allowedContent: true
      });  
    CKEDITOR.replace(('marcoLegalPlanEmergencia'), {
        fullPage: true,
        allowedContent: true
      });
     CKEDITOR.replace(('definicionesPlanEmergencia'), {
        fullPage: true,
        allowedContent: true
      }); 
     CKEDITOR.replace(('generalidadesPlanEmergencia'), {
        fullPage: true,
        allowedContent: true
      });  

    CKEDITOR.replace(('objetivosPlanEmergencia'), {
        fullPage: true,
        allowedContent: true
      });  

    CKEDITOR.replace(('alcancePlanEmergencia'), {
        fullPage: true,
        allowedContent: true
      });  


    $(document).ready(function()
    {
      mostrarFirma();
      mostrarImagen();
    });
    

</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}


@stop