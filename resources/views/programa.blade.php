@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Programa</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::script('js/programa.js')!!}
<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->


<?php 
//Se pregunta  si existe el id de Equipo Seguimiento Calibracion  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
$idPrograma = (isset($programa) ? $programa->idPrograma : 0);
?>


  <script>
    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
    var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

    var idDocumentoSoporte = '<?php echo isset($idDocumentoSoporte) ? $idDocumentoSoporte : "";?>';
    var nombreDocumentoSoporte = '<?php echo isset($nombreDocumentoSoporte) ? $nombreDocumentoSoporte : "";?>';
    var documentosoporte = [JSON.parse(idDocumentoSoporte),JSON.parse(nombreDocumentoSoporte)];

    console.log(nombreDocumentoSoporte);

    var programaDetalle = '<?php echo (isset($programa) ? json_encode($programa->programaDetalle) : "");?>';
    programaDetalle = (programaDetalle != '' ? JSON.parse(programaDetalle) : '');
    var valorPrograma = ['',0,0,'',0,'',0,''];

    $(document).ready(function(){


      programa = new Atributos('programa','contenedor_programa','programa_');
      programa.campos    = ['actividadProgramaDetalle', 'Tercero_idResponsable', 'Documento_idDocumento',
                            'fechaPlaneadaProgramaDetalle', 'recursoPlaneadoProgramaDetalle', 
                            'fechaEjecucionProgramaDetalle','recursoEjecutadoProgramaDetalle', 
                             'observacionProgramaDetalle'];
      programa.etiqueta  = ['input', 'select','select',  
                            'input', 'input',
                            'input', 'input', 
                            'input'];
      programa.tipo      = ['text', '', '',
                            'date', 'number', 
                            'date', 'number', 
                            'text'];
      programa.estilo    = ['width: 400px; height:35px; ', 
                            'width: 200px; height:35px; ', 
                            'width: 200px; height:35px; ', 
                            'width: 200px; height:35px; ', 
                            'width: 100px; height:35px; text-align: right;', 
                            'width: 200px; height:35px; ', 
                            'width: 100px; height:35px; text-align: right;', 
                            'width: 300px; height:35px; '];
      programa.clase     = ['', 'chosen-select', 'chosen-select', 
                            '', '',
                            '', '',
                            ''];
      programa.sololectura = [false,false,false,false,false,false,false,false];
      programa.completar = ['off', 'off','off','off','off','off','off','off'];
      programa.opciones = ['', tercero, documentosoporte,'','','','',''];
      var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
      programa.funciones  = [quitacarac, '','','','','','',quitacarac];



      programa.nombreCompletoTercero =  JSON.parse(nombreCompletoTercero);
      programa.idTercero =  JSON.parse(idTercero);
      programa.nombreDocumentoSoporte =  JSON.parse(nombreDocumentoSoporte);
      programa.idDocumentoSoporte =  JSON.parse(idDocumentoSoporte);


      for(var j=0, k = programaDetalle.length; j < k; j++)
      {
        programa.agregarCampos(JSON.stringify(programaDetalle[j]),'L');
      }
      document.getElementById('registros').value = j ;
    });

  </script>

  @if(isset($programa))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($programa,['route'=>['programa.destroy',$programa->idPrograma],'method'=>'DELETE', 'files' => true])!!}
    @else
      {!!Form::model($programa,['route'=>['programa.update',$programa->idPrograma],'method'=>'PUT', 'files' => true])!!}
    @endif
  @else
    {!!Form::open(['route'=>'programa.store','method'=>'POST'])!!}
  @endif


<div id='form-section' >

  <fieldset id="programa-form-fieldset">  
        <div class="form-group required" id='test'>
          {!!Form::label('nombrePrograma', 'Programa', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('nombrePrograma',null, ['class'=>'form-control', 'placeholder'=>'Ingresa el nombre del programa', 'style'=>'width:340;',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
              <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            </div>
          </div>
        </div>

        <div class="form-group required" id='test'>
          {!!Form::label('fechaElaboracionPrograma', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {!!Form::date('fechaElaboracionPrograma',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:300;'])!!}
            </div>
          </div>
        </div>

        <div class="form-group required" id='test'>
          {!!Form::label('ClasificacionRiesgo_idClasificacionRiesgo', 'Clasificaci&oacute;n  Riesgo', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag" ></i>
              </span>
              {!!Form::select('ClasificacionRiesgo_idClasificacionRiesgo',$clasificacionriesgo, (isset($programa) ? $programa->ClasificacionRiesgo_idClasificacionRiesgo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione la clasificacion de riesgo"])!!}
              {!! Form::hidden('idPrograma', 0, array('id' => 'idPrograma')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}

            </div>
          </div>
        </div>
        <div class="form-group" id='test'>
          {!!Form::label('alcancePrograma', 'Alcance', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('alcancePrograma',null, ['class'=>'form-control', 'placeholder'=>'Ingresa el alcance del programa', 'style'=>'width:340;',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
        </div>
    
        <div class="form-group required" id='test'>
          {!!Form::label('CompaniaObjetivo_idCompaniaObjetivo', 'Objetivo', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              {!!Form::select('CompaniaObjetivo_idCompaniaObjetivo',$companiaobjetivo, (isset($programa) ? $programa->CompaniaObjetivo_idCompaniaObjetivo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el objetivo general"])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('objetivoEspecificoPrograma', 'Objetivo Espec&iacute;fico', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::textarea('objetivoEspecificoPrograma',null,['class'=>'ckeditor','placeholder'=>'Objetivos espec&iacute;ficos del programa'])!!}
            </div>
          </div>
        </div>

        <div class="form-group required" id='test'>
          {!!Form::label('Tercero_idElabora', 'Elaborado Por', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              {!!Form::select('Tercero_idElabora',$terceros, (isset($programa) ? $programa->Tercero_idElabora : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Tercero que elabora el programa"])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('generalidadPrograma', 'Generalidades', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-edit" ></i>
              </span>
              {!!Form::textarea('generalidadPrograma',null,['class'=>'ckeditor','placeholder'=>'Generalidades del programa'])!!}
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
                                    <div class="dropzone dropzone-previews" id="dropzoneProgramaArchivo" style="overflow: auto;">
                                    </div>  
                                </div>  
                                  <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px; overflow: auto;">   
                                    {!!Form::hidden('ProgramaArchivoArray', '', array('id' => 'ProgramaArchivoArray'))!!}
                                    <?php
                                    
                                    // Cuando este editando el archivo 
                                    if ($idPrograma != '')  //Se pregunta si el id de manualgestion es diferente de vacio (que es la tabla papá)
                                    {
                                      $eliminar = '';
                                      $archivoSave = DB::Select('SELECT * from programaarchivo where Programa_idPrograma = '.$idPrograma);
                                      for ($i=0; $i <count($archivoSave) ; $i++) 
                                      { 
                                        $archivoS = get_object_vars($archivoSave[$i]);

                                        echo '<div id="'.$archivoS['idProgramaArchivo'].'" class="col-lg-4 col-md-4">
                                                    <div class="panel panel-yellow" style="border: 1px solid orange;">
                                                        <div class="panel-heading">
                                                            <div class="row">
                                                                <div class="col-xs-3">
                                                                    <a target="_blank" 
                                                                      href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaProgramaArchivo'].'">
                                                                      <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                                    </a>
                                                                </div>

                                                                <div class="col-xs-9 text-right">
                                                                    <div>'.str_replace('/programa/','',$archivoS['rutaProgramaArchivo']).'
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a target="_blank" href="javascript:eliminarArchivo('.$archivoS['idProgramaArchivo'].');">
                                                            <div class="panel-footer">
                                                                <span class="pull-left">Eliminar Documento</span>
                                                                <span class="pull-right"><i class="fa fa-times"></i></span>
                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>';

                                        echo '<input type="hidden" id="idProgramaArchivo[]" name="idProgramaArchivo[]" value="'.$archivoS['idProgramaArchivo'].'" >

                                        <input type="hidden" id="rutaProgramaArchivo[]" name="rutaProgramaArchivo[]" value="'.$archivoS['rutaProgramaArchivo'].'" >';
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



        <div class="form-group">
              <div class="col-lg-12">
                <div class="panel panel-default">
                  <div class="panel-heading">Detalles</div>
                    <div class="panel-body">
                      <div class="form-group" id='test'>
                        <div class="col-sm-12">
                          <div class="row show-grid">
                            <div style="overflow: auto; width: 100%;">
                              <div style="width: 1750px; height: 300px; display: inline-block; ">
                                <div class="col-md-1" style="width: 840px;">&nbsp;</div>
                                <div class="col-md-1" style="width: 300px;">Planeaci&oacute;n</div>
                                <div class="col-md-1" style="width: 300px;">Ejecuci&oacute;n</div>
                                <div class="col-md-1" style="width: 300px;">&nbsp;</div>
                                
                                <div class="col-md-1" style="width: 40px;height: 44px;" onclick="programa.agregarCampos(valorPrograma,'A')">
                                  <span class="glyphicon glyphicon-plus"></span>
                                </div>
                                  
                                <div class="col-md-1 requiredMulti" style="width: 400px;height: 44px;">Actividad</div>
                                <div class="col-md-2 requiredMulti" style="width: 200px;height: 44px;">Responsable</div>
                                <div class="col-md-3 requiredMulti" style="width: 200px;height: 44px;">Documento</div>
                                <div class="col-md-4" style="width: 200px;height: 44px;">Fecha</div>
                                <div class="col-md-5" style="width: 100px;height: 44px;">Recurso $</div>
                                <div class="col-md-6" style="width: 200px;height: 44px;">Fecha</div>
                                <div class="col-md-7" style="width: 100px;height: 44px;">Recurso $</div>
                                <div class="col-md-8" style="width: 300px;height: 44px;">Observaci&oacute;n</div>
                                <div id="contenedor_programa">
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
  @if(isset($programa))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
      @else
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"validarformulario(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarformulario(event);'])!!}
  @endif
  {!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
    
    $('#fechaElaboracionPrograma').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    
    CKEDITOR.replace(('objetivoEspecificoPrograma','generalidadPrograma'), {
        fullPage: true,
        allowedContent: false
    });

  </script>

  <script>
     //--------------------------------- DROPZONE  para Adjuntos---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneProgramaArchivo", {
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

    document.getElementById('ProgramaArchivoArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('ProgramaArchivoArray').value += file.name+',';
                        // console.log(document.getElementById('ProgramaArchivoArray').value);
                        i++;
                    });




  </script>


  </div>
</div>
@stop