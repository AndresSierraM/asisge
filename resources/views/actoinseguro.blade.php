@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Reporte de condiciones y actos Inseguros</center></h3>@stop

@section('content')
  @include('alerts.request')

<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->

	@if(isset($actoinseguro))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($actoinseguro,['route'=>['actoinseguro.destroy',$actoinseguro->idActoInseguro],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($actoinseguro,['route'=>['actoinseguro.update',$actoinseguro->idActoInseguro],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'actoinseguro.store','method'=>'POST'])!!}
	@endif

<?php
$idActoInseguroS = (isset($actoinseguro) ? $actoinseguro->idActoInseguro : 0);
?>

<div id='form-section' >
	<fieldset id="actoinseguro-form-fieldset">	
                                                                <!--Reportado Por  -->
                    <div class="form-group" id='test' >
                     {!!Form::label('Tercero_idEmpleadoReporta', 'Reportado Por', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-sm-6 " style="padding-left:10px">
                                            <div class="input-group">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-user" style="width: 14px;" aria-hidden="true"></i>
                                                     </span>                  
                               {!!Form::select('Tercero_idEmpleadoReporta',$TerceroReporta, (isset($actoinseguro) ? $actoinseguro->Tercero_idEmpleadoReporta : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                               </div>
                                    </div>
                                                                      <!--Fecha Elaboracion Acto Inseguro  -->
                                  <div class="form-group" id='test'>
                                     {!!Form::label('fechaElaboracionActoInseguro', 'Fecha', array('class' => 'col-sm-1 control-label')) !!}
                                          <div class="col-sm-3">
                                                <div class="input-group" >
                                                       <span class="input-group-addon">
                                                              <i class="fa fa-calendar"  style="width: 14px;" aria-hidden="true"></i>
                                                       </span>
                          {!!Form::text('fechaElaboracionActoInseguro',(isset($actoinseguro) ? $actoinseguro->fechaElaboracionActoInseguro : null),['class'=> 'form-control','placeholder'=>'Seleccione la Fecha de Elaboraci&#243;n'])!!}
                                                   </div>
                                          </div>
                                 </div>
                                 <input type="hidden" id="token" value="{{csrf_token()}}"/>
                                 {!!Form::hidden('idActoInseguro', null, array('id' => 'idActoInseguro'))!!}

                    </div>
                      <div class="form-group">
                        <div class="col-lg-12">
                          <div class="panel panel-default">
                            <div class="panel-heading">&nbsp;</div>
                            <div class="panel-body">
                              <div class="panel-group" id="accordion">
                                                                                      <!--Descripci&#243;n de la condici&#243;n o acto inseguro observado  -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#decripcion">Descripci&#243;n</a>
                                    </h4>
                                  </div>
                                  <div id="decripcion" class="panel-collapse collapse ">
                                    <div class="panel-body">
                                      <div class="form-group" id='test'>
                                        <div class="col-sm-12" style="width: 100%;">
                                          <div class="input-group">
                                            {!!Form::textarea('descripcionActoInseguro',null,['class'=>'ckeditor','placeholder'=>'Ingresa la descripcion'])!!}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                
                                </div>
                                                                                  <!-- Cu&#225;les cree que son las posibles consecuencias -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#consecuencias">Consecuencias</a>

                                    </h4>
                                  </div>
                                  <div id="consecuencias" class="panel-collapse collapse">
                                    <div class="panel-body">
                                      <div class="form-group" id='test'>
                                        <div class="col-sm-10 " style="width: 100%;">
                                          <div class="input-group">
                                            {!!Form::textarea('consecuenciasActoInseguro',null,['class'=>'ckeditor','placeholder'=>'Ingresa los objetivos'])!!}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                
                                </div>
                                              <!-- Ya que el panel cuando aparece el dropzone desaparece, se le agrega un style inline-block y el tamaño completo para que este no desaparezca -->
                                <div class="panel panel-default" style="display:inline-block;width:100%">
                                    <div class="panel-heading">
                                      <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#archivos">Adjuntos</a>
                                      </h4>
                                    </div>
                                  <div id="archivos" class="panel-collapse collapse">
                                    <div class="col-sm-12 col-xs-12">
                                        <div class="panel-body">
                                          <div class="col-sm-12 col-xs-12">
                                            <div id="upload" class="col-md-12">
                                                <div class="dropzone dropzone-previews" id="dropzoneActoInseguroArchivo">
                                                </div>  
                                            </div>                                                                             
                                            <div class="col-sm-12 col-xs-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;">   
                                              {!!Form::hidden('archivoActoInseguroArray', '', array('id' => 'archivoActoInseguroArray'))!!}
                                              <?php
                                                
                                                                  // Cuando este editando el archivo 
                                                  if ($idActoInseguroS != '')  //Se pregunta si el id de acta de capacitacion es diferente de vacio (que es la tabla papá)
                                                  {
                                                    $eliminar = '';
                                                    $archivoSave = DB::Select('SELECT * from actoinseguroarchivo where ActoInseguro_idActoInseguro = '.$idActoInseguroS);
                                                    for ($i=0; $i <count($archivoSave) ; $i++) 
                                                    { 
                                                      $archivoS = get_object_vars($archivoSave[$i]);

                                                      echo '<div id="'.$archivoS['idActoInseguroArchivo'].'" class="col-lg-4 col-md-4">
                                                                  <div class="panel panel-yellow" style="border: 1px solid orange;">
                                                                      <div class="panel-heading">
                                                                          <div class="row">
                                                                              <div class="col-xs-3">
                                                                                  <a target="_blank" 
                                                                                    href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaActoInseguroArchivo'].'">
                                                                                    <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                                                  </a>
                                                                              </div>

                                                                              <div class="col-xs-9 text-right">
                                                                                  <div>'.str_replace('/actoinseguro/','',$archivoS['rutaActoInseguroArchivo']).'
                                                                                  </div>
                                                                              </div>
                                                                          </div>
                                                                      </div>
                                                                      <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idActoInseguroArchivo'].');">
                                                                          <div class="panel-footer">
                                                                              <span class="pull-left">Eliminar Documento</span>
                                                                              <span class="pull-right"><i class="fa fa-times"></i></span>
                                                                              <div class="clearfix"></div>
                                                                          </div>
                                                                      </a>
                                                                  </div>
                                                              </div>';

                                                      echo '<input type="hidden" id="idActoInseguroArchivo[]" name="idActoInseguroArchivo[]" value="'.$archivoS['idActoInseguroArchivo'].'" >

                                                      <input type="hidden" id="rutaActoInseguroArchivo[]" name="rutaActoInseguroArchivo[]" value="'.$archivoS['rutaActoInseguroArchivo'].'" >';
                                                    }

                                                    echo '<input type="hidden" name="eliminarArchivo" id="eliminarArchivo" value="">';
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
                                                                    <!--Reportado Por  -->
                    <div class="form-group" id='test'>
                     {!!Form::label('estadoActoInseguro', 'Estado', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-sm-6" style="padding-left:10px">
                                            <div class="input-group">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-bars" style="width: 14px;" aria-hidden="true"></i>
                                                     </span>                  
                               {!!Form::select('estadoActoInseguro',array('REGISTRADO'=>'Registrado','ANALISIS'=>'En análisis','RECHAZADO'=>'Rechazado','SOLUCIONADO'=>'Solucionado','PLANACCION'=>'En plan de acción'),(isset($actoinseguro) ? $actoinseguro->estadoActoInseguro : 0),["class" =>"form-control"])!!}
                                               </div>
                                    </div>
                                                                      <!--Fecha Solucion Acto Inseguro  -->
                                  <div class="form-group" id='test'>
                                     {!!Form::label('fechaSolucionActoInseguro', 'Fecha', array('class' => 'col-sm-1 control-label')) !!}
                                          <div class="col-sm-3">
                                                <div class="input-group" >
                                                       <span class="input-group-addon">
                                                              <i class="fa fa-calendar"  style="width: 14px;" aria-hidden="true"></i>
                                                       </span>
                          {!!Form::text('fechaSolucionActoInseguro',(isset($actoinseguro) ? $actoinseguro->fechaSolucionActoInseguro : null),['class'=> 'form-control','placeholder'=>'Seleccione la Fecha de Solucion'])!!}
                                                   </div>
                                          </div>
                                 </div>
                    </div>
                    <div class="form-group" id='test'>
                     {!!Form::label('Tercero_idEmpleadoSoluciona', 'Qui&#233;n Soluciona', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-sm-6 " style="padding-left:10px">
                                            <div class="input-group">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-user" style="width: 14px;" aria-hidden="true"></i>
                                                     </span>                  
                               {!!Form::select('Tercero_idEmpleadoSoluciona',$TerceroSoluciona, (isset($actoinseguro) ? $actoinseguro->Tercero_idEmpleadoSoluciona : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                               </div>
                                    </div>
                    </div>
    </fieldset>
    <br>
	@if(isset($actoinseguro))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif
	{!! Form::close() !!}
</div>



<script>

 CKEDITOR.replace(('descripcionActoInseguro','consecuenciasActoInseguro'), {
        fullPage: true,
        allowedContent: true
      }); 

 $(document).ready( function () {

   $('#fechaElaboracionActoInseguro').datetimepicker(({
      format: "YYYY-MM-DD"
    }));
   $('#fechaSolucionActoInseguro').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

  });
</script> 

<script>
  //--------------------------------- DROPZONE ---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneActoInseguroArchivo", {
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

    document.getElementById('archivoActoInseguroArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('archivoActoInseguroArray').value += file.name+',';
                        // console.log(document.getElementById('archivoActoInseguroArray').value);
                        i++;
                    });


    // Se hace una funcion para que elimine los archivos que estan subidos en el dropzone y estan siendo mostrados en la preview
function eliminarDiv(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarArchivo").val( $("#eliminarArchivo").val() + idDiv + ",");  
    }
}

</script>

@stop