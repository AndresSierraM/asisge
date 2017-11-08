@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Manual del sistema de gesti&oacute;n</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::style('css/signature-pad.css'); !!} 
{!!Html::style('css/image-pad.css'); !!} 

{!!Html::script('js/manualgestion.js')!!}
<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->


<?php



  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  $base64 = ''; 
  if(isset($manualgestion))
  {
    $path = 'imagenes/'.$manualgestion["firmaEmpleadorManualGestion"];
    
    if($manualgestion["firmaEmpleadorManualGestion"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
  }
?> 


<?php 
//Se pregunta  si existe el id de Equipo Seguimiento Calibracion  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
$idManualGestion = (isset($manualgestion) ? $manualgestion->idManualGestion : 0);
?>


  <script>
     // Se recibe la consulta de la multigistro para que muestre los datos de los campos en multi limite
   var ManualGestionParteDetalle = '<?php echo (isset($ManualGestionParte) ? json_encode($ManualGestionParte) : "");?>';
  ManualGestionParteDetalle = (ManualGestionParteDetalle != '' ? JSON.parse(ManualGestionParteDetalle) : '');



// Datos para mutiregistro Partes Interesadas
var ParteInteresadaDatos = ['','','','',''];



   $(document).ready(function(){
     

                            // MULTIREGISTRO LIMITE
      parteinteresada = new Atributos('parteinteresada','parteinteresados_detalle','detalle_');
      parteinteresada.altura = '36px;';
      parteinteresada.campoid = 'idManualGestionParte';
      parteinteresada.campoEliminacion = 'eliminarparteinteresada';
      parteinteresada.botonEliminacion = true;
      parteinteresada.campos = ['idManualGestionParte','ManualGestion_idManualGestion','interesadoManualGestionParte','necesidadManualGestionParte', 'cumplimientoManualGestionParte'];
      parteinteresada.etiqueta = ['input','input','textarea','textarea','textarea'];
      parteinteresada.tipo = ['hidden','hidden','textarea','textarea','textarea'];
      parteinteresada.estilo = ['','','vertical-align:top; width: 300px;height:35px;','vertical-align:top; width: 300px;height:35px;','vertical-align:top; width: 400px;height:35px;'];
      parteinteresada.clase = ['','','','',''];
      parteinteresada.sololectura = [false,false,false,false,false];
      parteinteresada.opciones = ['','','','',''];
      var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
      parteinteresada.funciones = ['','',quitacarac,quitacarac,quitacarac];


        // For para llenar los registros al momento de modificar el registro manual gestion parte
      for(var j=0, k = ManualGestionParteDetalle.length; j < k; j++)
      {       
        parteinteresada.agregarCampos(JSON.stringify(ManualGestionParteDetalle[j]),'L');       
      }



    });
  </script>

  @if(isset($manualgestion))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($manualgestion,['route'=>['manualgestion.destroy',$manualgestion->idManualGestion],'method'=>'DELETE', 'files' => true])!!}
    @else
      {!!Form::model($manualgestion,['route'=>['manualgestion.update',$manualgestion->idManualGestion],'method'=>'PUT', 'files' => true])!!}
    @endif
  @else
    {!!Form::open(['route'=>'manualgestion.store','method'=>'POST', 'files' => true])!!}
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
              {!! Form::label('codigoManualGestion', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-addon">
                    <i class="fa fa-barcode"></i>
                  </span>
                  {!!Form::text('codigoManualGestion',null,['class'=>'form-control','placeholder'=>'Ingresa el código'])!!}
                  {!! Form::hidden('idManualGestion', null, array('id' => 'idManualGestion')) !!}
                   {!!Form::hidden('eliminarparteinteresada',null, array('id' => 'eliminarparteinteresada'))!!}

                  
                </div>
              </div>
            </div>
           <div class="form-group required" id='test'>
                {!!Form::label('nombreManualGestion', 'Nombre ', array('class' => 'col-sm-2 control-label')) !!}
                <div class="col-sm-10">
                    <div class="input-group"> 
                        <span class="input-group-addon">
                          <i class="fa fa-pencil-square-o" style="width: 14px";></i>
                          </span>
                    {!!Form::text('nombreManualGestion',null,['class'=>'form-control','placeholder'=>'Por favor ingrese el Nombre',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
                      <input type="hidden" id="token" value="{{csrf_token()}}"/>   
                    </div>
                 </div>
            </div>
            <div class="form-group required" id='test'>
                {!!Form::label('fechaManualGestion', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
                <div class="col-sm-10" >
                  <div class="input-group">
                    <span class="input-group-addon">
                      <i class="fa fa-calendar" ></i>
                    </span>
                    {!!Form::text('fechaManualGestion',null, ['style'=>'height:100%;','class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
                  </div>
                </div>
            </div>
            <div class="form-group required" id='test'>
                  {!!Form::label('Tercero_idEmpleador', 'Firma del empleador', array('class' => 'col-sm-2 control-label'))!!}       
                  <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-flag"></i>
                        </span>
                      {!!Form::select('Tercero_idEmpleador',$tercero, (isset($manualgestion) ? $manualgestion->Tercero_idEmpleador : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el empleador"])!!}
                      <div class="col-sm-10">
                        <img id="firma" style="width:200px; height: 150px; border: 1px solid;" onclick="mostrarFirma();" src="<?php echo $base64;?>">
                        {!!Form::hidden('firmabase64', $base64, array('id' => 'firmabase64'))!!}
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
                         <!-- Acordeon  Generalidades-->
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
                                {!!Form::textarea('generalidadesManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese las generalidades'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Acordeon Mision -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#mision">Misi&oacute;n</a>
                        </h4>
                      </div>
                      <div id="mision" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('misionManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese la misi&oacute;n'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <!-- Acordeon Vision -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#vision">Visi&oacute;n</a>
                        </h4>
                      </div>
                      <div id="vision" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('visionManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese la visi&oacute;n'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                      <!-- Acordeon Valores -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Valores">Valores</a>
                        </h4>
                      </div>
                      <div id="Valores" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('valoresManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese los Valores'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Acordeon politicas -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#politicas">Pol&#237;ticas</a>
                        </h4>
                      </div>
                      <div id="politicas" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('politicasManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese las Pol&#237;ticas'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <!-- Acordeon Principios -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Principios">Principios</a>
                        </h4>
                      </div>
                      <div id="Principios" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('principiosManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese los Principios'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Acordeon Metas -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Metas">Metas</a>
                        </h4>
                      </div>
                      <div id="Metas" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('metasManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese las Metas'])!!}
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
                                {!!Form::textarea('objetivosManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese los Objetivos'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                       <!-- Acordeon Objetivo del manual de calidad -->
                   <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#objetivomanual">Objetivo del manual de calidad</a>
                        </h4>
                      </div>
                      <div id="objetivomanual" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('objetivoCalidadManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese el Objetivo del manual de calidad'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                     <!-- Acordeon Alcance del sistema de gesti&oacute;n -->
                   <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#alcance">Alcance del sistema de gesti&oacute;n</a>
                        </h4>
                      </div>
                      <div id="alcance" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('alcanceManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese el Alcance del sistema de gesti&oacute;n'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                        <!-- Acordeon Exclusiones -->
                   <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#Exclusiones">Exclusiones</a>
                        </h4>
                      </div>
                      <div id="Exclusiones" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('exclusionesManualGestion',null,['style'=>'height:100%;','class'=>'form-control','placeholder'=>'Ingrese las Exclusiones'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                         <!-- Acordeon partes Interesadas -->
                     <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#partes">Partes interesadas</a>
                        </h4>
                      </div>
                      <div id="partes" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group" id='test'>
                                <div class="col-sm-12">

                                  <div class="row show-grid">
                                    <div class="col-md-1" style="width: 40px;height: 35px;" onclick="parteinteresada.agregarCampos(ParteInteresadaDatos,'A')">
                                      <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1 requiredMulti" style="width: 300px;display:inline-block;height:35px;">Parte interesada</div>
                                    <div class="col-md-1 requiredMulti" style="width: 300px;display:inline-block;height:35px;">Necesidades o requerimientos</div>
                                    <div class="col-md-1 requiredMulti" style="width: 400px;display:inline-block;height:35px;">Cómo se cumplen las necesidades / requerimienos</div>
                                    <!-- este es el div para donde van insertando los registros --> 
                                    <div id="parteinteresados_detalle">
                                    </div>
                                  </div>
                                </div>
                            </div>                      
                        </div>
                    </div>
                  </div>
                                           <!-- Nuevo pestaña para adjuntar archivos -->
                                              <!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
                      <div class="panel panel-default" style="display:inline-block;width:100%">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#interaccion">Interacci&oacute;n de los procesos</a>
                          </h4>
                        </div>
                        <div id="interaccion" class="panel-collapse collapse">
                          <div class="col-sm-12">
                                        <div class="panel-heading ">
                                            <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
                                        </div>
                                          <div class="panel-body">
                              <div class="col-sm-12" >
                                <div id="upload" class="col-md-12">
                                    <div class="dropzone dropzone-previews" id="dropzoneInteraccionproceso" style="overflow: auto;">
                                    </div>  
                                </div>  
                                  <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px; overflow: auto;">   
                                    {!!Form::hidden('InteraccionProcesoArray', '', array('id' => 'InteraccionProcesoArray'))!!}
                                    <?php
                                    
                                    // Cuando este editando el archivo 
                                    if ($idManualGestion != '')  //Se pregunta si el id de manualgestion es diferente de vacio (que es la tabla papá)
                                    {
                                      $eliminar = '';
                                      $archivoSave = DB::Select('SELECT * from manualgestionproceso where ManualGestion_idManualGestion = '.$idManualGestion);
                                      for ($i=0; $i <count($archivoSave) ; $i++) 
                                      { 
                                        $archivoS = get_object_vars($archivoSave[$i]);

                                        echo '<div id="'.$archivoS['idManualGestionProceso'].'" class="col-lg-4 col-md-4">
                                                    <div class="panel panel-yellow" style="border: 1px solid orange;">
                                                        <div class="panel-heading">
                                                            <div class="row">
                                                                <div class="col-xs-3">
                                                                    <a target="_blank" 
                                                                      href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaManualGestionProceso'].'">
                                                                      <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="col-xs-9 text-right">
                                                                    <div>'.str_replace('/manualgestion/','',$archivoS['rutaManualGestionProceso']).'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a target="_blank" href="javascript:eliminarProceso('.$archivoS['idManualGestionProceso'].');">
                                                            <div class="panel-footer">
                                                                <span class="pull-left">Eliminar Documento</span>
                                                                <span class="pull-right"><i class="fa fa-times"></i></span>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>';

                                        echo '<input type="hidden" id="idManualGestionProceso[]" name="idManualGestionProceso[]" value="'.$archivoS['idManualGestionProceso'].'" >

                                        <input type="hidden" id="rutaManualGestionProceso[]" name="rutaManualGestionProceso[]" value="'.$archivoS['rutaManualGestionProceso'].'" >';
                                      }

                                      echo '<input type="hidden" name="eliminarProceso" id="eliminarProceso" value="">';
                                    }
                                              
                                    ?>              
                                  </div>
                              </div>
                            </div>                        
                          </div>
                        </div>
                      </div>
                                                                 <!-- Nuevo pestaña para adjuntar archivos -->
                                              <!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
                      <div class="panel panel-default" style="display:inline-block;width:100%">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#estructura">Estructura organizacional</a>
                          </h4>
                        </div>
                        <div id="estructura" class="panel-collapse collapse">
                          <div class="col-sm-12">
                                        <div class="panel-heading ">
                                            <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
                                        </div>
                                          <div class="panel-body">
                              <div class="col-sm-12" >
                                <div id="upload" class="col-md-12">
                                    <div class="dropzone dropzone-previews" id="dropzoneEstructuraOrganizacional" style="overflow: auto;">
                                    </div>  
                                </div>  
                                  <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px; overflow: auto;">   
                                    {!!Form::hidden('EstructuraOrganizacionalArray', '', array('id' => 'EstructuraOrganizacionalArray'))!!}
                                    <?php
                                    
                                    // Cuando este editando el archivo 
                                    if ($idManualGestion != '')  //Se pregunta si el id de manualgestion es diferente de vacio (que es la tabla papá)
                                    {
                                      $eliminar = '';
                                      $archivoSave = DB::Select('SELECT * from manualgestionestructura where ManualGestion_idManualGestion = '.$idManualGestion);
                                      for ($i=0; $i <count($archivoSave) ; $i++) 
                                      { 
                                        $archivoS = get_object_vars($archivoSave[$i]);

                                        echo '<div id="'.$archivoS['idManualGestionEstructura'].'" class="col-lg-4 col-md-4">
                                                    <div class="panel panel-yellow" style="border: 1px solid orange;">
                                                        <div class="panel-heading">
                                                            <div class="row">
                                                                <div class="col-xs-3">
                                                                    <a target="_blank" 
                                                                      href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaManualGestionEstructura'].'">
                                                                      <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="col-xs-9 text-right">
                                                                    <div>'.str_replace('/manualgestion/','',$archivoS['rutaManualGestionEstructura']).'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a target="_blank" href="javascript:eliminarEstructura('.$archivoS['idManualGestionEstructura'].');">
                                                            <div class="panel-footer">
                                                                <span class="pull-left">Eliminar Documento</span>
                                                                <span class="pull-right"><i class="fa fa-times"></i></span>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>';

                                        echo '<input type="hidden" id="idManualGestionEstructura[]" name="idManualGestionEstructura[]" value="'.$archivoS['idManualGestionEstructura'].'" >

                                        <input type="hidden" id="rutaManualGestionEstructura[]" name="rutaManualGestionEstructura[]" value="'.$archivoS['rutaManualGestionEstructura'].'" >';
                                      }

                                      echo '<input type="hidden" name="eliminarEstructura" id="eliminarEstructura" value="">';
                                    }
                                              
                                    ?>              
                                  </div>
                              </div>
                            </div>                        
                          </div>
                        </div>
                      </div>
                                                                  <!-- Nuevo pestaña para adjuntar archivos -->
                                              <!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
                      <div class="panel panel-default" style="display:inline-block;width:100%">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#Archivos">Archivos</a>
                          </h4>
                        </div>
                        <div id="Archivos" class="panel-collapse collapse">
                          <div class="col-sm-12">
                                        <div class="panel-heading ">
                                            <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
                                        </div>
                                          <div class="panel-body">
                              <div class="col-sm-12" >
                                <div id="upload" class="col-md-12">
                                    <div class="dropzone dropzone-previews" id="dropzoneManualGestionAdjunto" style="overflow: auto;">
                                    </div>  
                                </div>  
                                  <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px; overflow: auto;">   
                                    {!!Form::hidden('ManualGestionAdjuntoArray', '', array('id' => 'ManualGestionAdjuntoArray'))!!}
                                    <?php
                                    
                                    // Cuando este editando el archivo 
                                    if ($idManualGestion != '')  //Se pregunta si el id de manualgestion es diferente de vacio (que es la tabla papá)
                                    {
                                      $eliminar = '';
                                      $archivoSave = DB::Select('SELECT * from manualgestionadjunto where ManualGestion_idManualGestion = '.$idManualGestion);
                                      for ($i=0; $i <count($archivoSave) ; $i++) 
                                      { 
                                        $archivoS = get_object_vars($archivoSave[$i]);

                                        echo '<div id="'.$archivoS['idManualGestionAdjunto'].'" class="col-lg-4 col-md-4">
                                                    <div class="panel panel-yellow" style="border: 1px solid orange;">
                                                        <div class="panel-heading">
                                                            <div class="row">
                                                                <div class="col-xs-3">
                                                                    <a target="_blank" 
                                                                      href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaManualGestionAdjunto'].'">
                                                                      <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="col-xs-9 text-right">
                                                                    <div>'.str_replace('/manualgestion/','',$archivoS['rutaManualGestionAdjunto']).'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a target="_blank" href="javascript:eliminarAdjunto('.$archivoS['idManualGestionAdjunto'].');">
                                                            <div class="panel-footer">
                                                                <span class="pull-left">Eliminar Documento</span>
                                                                <span class="pull-right"><i class="fa fa-times"></i></span>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>';

                                        echo '<input type="hidden" id="idManualGestionAdjunto[]" name="idManualGestionAdjunto[]" value="'.$archivoS['idManualGestionAdjunto'].'" >

                                        <input type="hidden" id="rutaManualGestionAdjunto[]" name="rutaManualGestionAdjunto[]" value="'.$archivoS['rutaManualGestionAdjunto'].'" >';
                                      }

                                      echo '<input type="hidden" name="eliminarAdjunto" id="eliminarAdjunto" value="">';
                                    }
                                              
                                    ?>              
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
  @if(isset($manualgestion))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
      @else
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"validarFormulario(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
  @endif
  
  

  {!! Form::close() !!}

  </div>
</div>


  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
    
    $('#fechaManualGestion').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    CKEDITOR.replace(('generalidadesManualGestion'), {
        fullPage: true,
        allowedContent: true,
        

      });  
    CKEDITOR.replace(('misionManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
    CKEDITOR.replace(('visionManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
    CKEDITOR.replace(('valoresManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
    CKEDITOR.replace(('politicasManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
    CKEDITOR.replace(('principiosManualGestion'), {
        fullPage: true,
        allowedContent: true
      });

    CKEDITOR.replace(('metasManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
    CKEDITOR.replace(('objetivosManualGestion'), {
        fullPage: true,
        allowedContent: true
      });

   CKEDITOR.replace(('objetivoCalidadManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
   CKEDITOR.replace(('alcanceManualGestion'), {
        fullPage: true,
        allowedContent: true
      });
  CKEDITOR.replace(('exclusionesManualGestion'), {
        fullPage: true,
        allowedContent: true
      });


 $(document).ready(function()
    {
      mostrarFirma();
      mostrarImagen();
    });
    



</script>

<script>
    //--------------------------------- DROPZONE ---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneInteraccionproceso", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

     fileList = Array();
    var i = 0;

    //Configuro el dropzone
    myDropzone.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    accept: function(file, done) {

      }
    };
    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('InteraccionProcesoArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('InteraccionProcesoArray').value += file.name+',';
                        // console.log(document.getElementById('InteraccionProcesoArray').value);
                        i++;
                    });


    //--------------------------------- DROPZONE  para Estructura organizacional---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneEstructuraOrganizacional", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

     fileList = Array();
    var i = 0;

    //Configuro el dropzone
    myDropzone.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    accept: function(file, done) {

      }
    };
    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('EstructuraOrganizacionalArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('EstructuraOrganizacionalArray').value += file.name+',';
                        // console.log(document.getElementById('EstructuraOrganizacionalArray').value);
                        i++;
                    });



    //--------------------------------- DROPZONE  para Adjuntos---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneManualGestionAdjunto", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

     fileList = Array();
    var i = 0;

    //Configuro el dropzone
    myDropzone.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    accept: function(file, done) {

      }
    };
    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('ManualGestionAdjuntoArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('ManualGestionAdjuntoArray').value += file.name+',';
                        // console.log(document.getElementById('ManualGestionAdjuntoArray').value);
                        i++;
                    });







</script>

{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}

@stop