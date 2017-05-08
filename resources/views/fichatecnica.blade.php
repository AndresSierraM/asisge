@extends('layouts.grid')

@section('titulo')<h3 id="titulo"><center>Ficha Técnica</center></h3>@stop

@section('content')
@include('alerts.request')

<script type="">
    var procesos = '<?php echo (isset($proceso) ? json_encode($proceso) : "");?>';
    procesos = (procesos != '' ? JSON.parse(procesos) : '');

    var materiales = '<?php echo (isset($material) ? json_encode($material) : "");?>';
    materiales = (materiales != '' ? JSON.parse(materiales) : '');

    var operaciones = '<?php echo (isset($operacion) ? json_encode($operacion) : "");?>';
    operaciones = (operaciones != '' ? JSON.parse(operaciones) : '');

    var valorProceso = ['','','','','','','',''];

</script>

{!!Html::script('js/fichatecnica.js')!!}
{!!Html::style('css/fichatecnica.css')!!}

{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->

{!!Html::style('sb-admin/bower_components/fileinput/css/fileinput.css'); !!}
{!!Html::script('sb-admin/bower_components/fileinput/js/fileinput.js'); !!}
{!!Html::script('sb-admin/bower_components/fileinput/js/fileinput_locale_es.js'); !!}


	@if(isset($fichatecnica))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($fichatecnica,['route'=>['fichatecnica.destroy',$fichatecnica->idFichaTecnica],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($fichatecnica,['route'=>['fichatecnica.update',$fichatecnica->idFichaTecnica],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'fichatecnica.store','method'=>'POST'])!!}
	@endif

<?php 
$idFichaTecnicaA = (isset($fichatecnica->idFichaTecnica) ? $fichatecnica->idFichaTecnica : 0);

$fechahora = Carbon\Carbon::now();
?>



<div id='form-section' >
	<fieldset id="fichatecnica-form-fieldset">	
    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('LineaProducto_idLineaProducto', 'Linea', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('LineaProducto_idLineaProducto',$linea, @$fichatecnica->LineaProducto_idLineaProducto,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
        </div>
      </div>
    </div>	

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('SublineaProducto_idSublineaProducto', 'Sublinea', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::select('SublineaProducto_idSublineaProducto',$sublinea, @$fichatecnica->SublineaProducto_idSublineaProducto ,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('Tercero_idTercero', 'Cliente', array())!!}
      </div>
      <div class="col-sm-8">
        <div class="input-group">
          <span class="input-group-addon">
            <i class="fa fa-pencil-square-o"></i>
          </span>
          {!!Form::select('Tercero_idTercero',$tercero, @$fichatecnica->Tercero_idTercero,["class" => "chosen-select form-control", "placeholder" => "Seleccione"])!!}
        </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('referenciaClienteFichaTecnica', 'Referencia Cliente', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('referenciaClienteFichaTecnica',null,['class'=>'form-control', "placeholder" => "Ingrese Referencia del Cliente"])!!}
            {!!Form::hidden('idFichaTecnica',null,['id'=>'idFichaTecnica'])!!}
            {!!Form::hidden('eliminarProceso',null,['id'=>'eliminarProceso'])!!}
            {!!Form::hidden('eliminarMaterial',null,['id'=>'eliminarMaterial'])!!}
            {!!Form::hidden('eliminarOperacion',null,['id'=>'eliminarOperacion'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('referenciaFichaTecnica', 'Referencia', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('referenciaFichaTecnica',null,['class'=>'form-control', "placeholder" => "Ingrese Referencia"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('nombreFichaTecnica', 'Descripción', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('nombreFichaTecnica',null,['class'=>'form-control', "placeholder" => "Ingrese Descripción del producto"])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('fechaCreacionFichaTecnica', 'Fecha Creación', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::text('fechaCreacionFichaTecnica',(isset($fichatecnica) ? $fichatecnica->fechaCreacionFichaTecnica : $fechahora),['readonly'=>'readonly', 'class'=>'form-control'])!!}
          </div>
      </div>
    </div>  

    <div class="col-sm-6">
      <div class="col-sm-4">
        {!!Form::label('estadoFichaTecnica', 'Estado', array())!!}
      </div>
      <div class="col-sm-8">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o"></i>
            </span>
            {!!Form::select('estadoFichaTecnica',['Prototipo'=>'Prototipo','Muestra'=>'Muestra','Aprobado'=>'Aprobado'], @$fichatecnica->estadoFichaTecnica,["class" => "chosen-select form-control"])!!}
          </div>
      </div>
    </div> 


  </fieldset>



<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#imagen">Imágenes</a></li>
  <li><a data-toggle="tab" href="#proceso">Ruta de Procesos</a></li>
  <li><a data-toggle="tab" href="#material">Materiales</a></li>
  <li><a data-toggle="tab" href="#operacion">Operaciones</a></li>
  <li><a data-toggle="tab" href="#adjunto">Adjuntos</a></li>
  <li><a data-toggle="tab" href="#nota">Notas</a></li>
  <li><a data-toggle="tab" href="#auditoria">Auditoría</a></li>
</ul>

<div class="tab-content">
  <div id="imagen" class="tab-pane fade in active">
    <div class="col-sm-12">
      <div class="panel panel-primary">
          <div class="panel-heading">
            <i class="fa fa-pencil-square-o"></i> {!!Form::label('', 'Imágenes', array())!!}
          </div>
      <div class="panel-body">
          <div class="col-sm-12">
            <div id="upload" class="col-md-12">
                <div class="dropzone dropzone-previews" id="dropzoneFichaTecnicaImagen">
                </div>  
            </div>  
          
            
            <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:500px; overflow: auto;">   
            {!!Form::hidden('imagenFichaTecnicaArray', '', array('id' => 'imagenFichaTecnicaArray'))!!}
              <?php

              if ($idFichaTecnicaA != '') 
              {
                $eliminar = '';
                $imagenSave = DB::Select('SELECT * from fichatecnicaimagen where FichaTecnica_idFichaTecnica = '.$idFichaTecnicaA);

                for ($i=0; $i <count($imagenSave) ; $i++) 
                { 
                  $imagenS = get_object_vars($imagenSave[$i]);

                  echo '<div id="'.$imagenS['idFichaTecnicaImagen'].'" class="col-lg-4 col-md-4" >
                              <div class="panel panel-yellow" style="border: 1px solid orange;">
                                  <div class="panel-heading">
                                      <div class="row">
                                          <div class="col-xs-3">
                                              <a target="_blank" 
                                                href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$imagenS['rutaFichaTecnicaImagen'].'">
                                                <img src="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$imagenS['rutaFichaTecnicaImagen'].'" style="height:200px;"></img>
                                              </a>
                                          </div>
                                          <div class="col-xs-9 text-right">
                                              <div>'.str_replace('/movimientocrm/','',$imagenS['rutaFichaTecnicaImagen']).'
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <a target="_blank" href="javascript:eliminarDiv('.$imagenS['idFichaTecnicaImagen'].');">
                                      <div class="panel-footer">
                                          <span class="pull-left">Eliminar Documento</span>
                                          <span class="pull-right"><i class="fa fa-times"></i></span>
                                          <div class="clearfix"></div>
                                      </div>
                                  </a>
                              </div>
                          </div>';

                  echo '<input type="hidden" id="idFichaTecnicaImagen[]" name="idFichaTecnicaImagen[]" value="'.$imagenS['idFichaTecnicaImagen'].'" >

                  <input type="hidden" id="rutaFichaTecnicaImagen[]" name="rutaFichaTecnicaImagen[]" value="'.$imagenS['rutaFichaTecnicaImagen'].'" >';
                }

                echo '<input type="hidden" name="eliminarImagen" id="eliminarImagen" value="">';
              }
              
               ?>             
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="proceso" class="tab-pane fade">
    <div class="form-group" id='test'>
        <div class="col-sm-12">
            <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                <div style="overflow:auto; height:350px;">
                    <div style="width: 100%; display: inline-block;">
                        <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="abrirModalProceso(materiales, operaciones);">
                          <span class="glyphicon glyphicon-plus"></span>
                        </div>
                        <div class="col-md-1" style="width: 100px;" >Orden</div>
                        <div class="col-md-1" style="width: 400px;" >Proceso</div>
                        <div class="col-md-1" style="width: 400px;" >Observaciones</div>
                        <div id="contenedor_proceso">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div id="material" class="tab-pane fade">
    <div id='tabsMaterial'>
      <ul class="nav nav-tabs">
      </ul>
    </div>

  </div>
  <div id="operacion" class="tab-pane fade">
    <div id='tabsOperacion'>
      <ul class="nav nav-tabs">
      </ul>
    </div>

  </div>
  <div id="adjunto" class="tab-pane fade">
    <div class="col-sm-12">
      <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-pencil-square-o"></i> {!!Form::label('', 'Archivos Adjuntos', array())!!}
                        </div>
                        <div class="panel-body">
          <div class="col-sm-12">
            <div id="upload" class="col-md-12">
                <div class="dropzone dropzone-previews" id="dropzoneFichaTecnicaArchivo">
                </div>  
            </div>  
          
            
            <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;">   
            {!!Form::hidden('archivoFichaTecnicaArray', '', array('id' => 'archivoFichaTecnicaArray'))!!}
              <?php

              if ($idFichaTecnicaA != '') 
              {
                $eliminar = '';
                $archivoSave = DB::Select('SELECT * from fichatecnicaarchivo where FichaTecnica_idFichaTecnica = '.$idFichaTecnicaA);

                for ($i=0; $i <count($archivoSave) ; $i++) 
                { 
                  $archivoS = get_object_vars($archivoSave[$i]);

                  echo '<div id="'.$archivoS['idFichaTecnicaArchivo'].'" class="col-lg-4 col-md-4">
                              <div class="panel panel-yellow" style="border: 1px solid orange;">
                                  <div class="panel-heading">
                                      <div class="row">
                                          <div class="col-xs-3">
                                              <a target="_blank" 
                                                href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaFichaTecnicaArchivo'].'">
                                                <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                              </a>
                                          </div>
                                          <div class="col-xs-9 text-right">
                                              <div>'.str_replace('/movimientocrm/','',$archivoS['rutaFichaTecnicaArchivo']).'
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idFichaTecnicaArchivo'].');">
                                      <div class="panel-footer">
                                          <span class="pull-left">Eliminar Documento</span>
                                          <span class="pull-right"><i class="fa fa-times"></i></span>
                                          <div class="clearfix"></div>
                                      </div>
                                  </a>
                              </div>
                          </div>';

                  echo '<input type="hidden" id="idFichaTecnicaArchivo[]" name="idFichaTecnicaArchivo[]" value="'.$archivoS['idFichaTecnicaArchivo'].'" >

                  <input type="hidden" id="rutaFichaTecnicaArchivo[]" name="rutaFichaTecnicaArchivo[]" value="'.$archivoS['rutaFichaTecnicaArchivo'].'" >';
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

  <div id="nota" class="tab-pane fade">
    

  </div>
  <div id="auditoria" class="tab-pane fade">
    

  </div>
</div>

    <br>
	@if(isset($fichatecnica))
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



<script type="text/javascript">


//--------------------------------- DROPZONE ---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var DropzoneImagen = new Dropzone("div#dropzoneFichaTecnicaImagen", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

     fileList = Array();
    var i = 0;

    //Configuro el dropzone
    DropzoneImagen.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    acceptedFiles: "image/jpeg,image/png,image/gif",
    accept: function(file, done) {

      }
    };
    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     DropzoneImagen.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('imagenFichaTecnicaArray').value = '';
    DropzoneImagen.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('imagenFichaTecnicaArray').value += file.name+',';
                        // console.log(document.getElementById('imagenFichaTecnicaArray').value);
                        i++;
                    });



//--------------------------------- DROPZONE ---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var DropzoneArchivo = new Dropzone("div#dropzoneFichaTecnicaArchivo", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

     fileList = Array();
    var i = 0;

    //Configuro el dropzone
    DropzoneArchivo.options.myAwesomeDropzone =  {
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
     DropzoneArchivo.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('archivoFichaTecnicaArray').value = '';
    DropzoneArchivo.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('archivoFichaTecnicaArray').value += file.name+',';
                        // console.log(document.getElementById('archivoFichaTecnicaArray').value);
                        i++;
                    });
</script>

@stop

<div id="ModalProceso" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Conceptos</h4>
      </div>
      <div class="modal-body">
         <div class="container">
            <div class="row">
                <div class="container">
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button  type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                       <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Código</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Proceso</label></a></li>
                            
                        </ul>
                    </div>
                    
                    <table id="tproceso" name="tproceso" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">

                                <th><b>ID</b></th>
                                <th><b>Código</b></th>
                                <th><b>Proceso</b></th>        
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">

                                <th>ID</th>
                                <th>Código</th>
                                <th>Proceso</th>                             
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal-footer">
                        <button id="botonCampo" name="botonCampo" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>

                

                </div>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>
