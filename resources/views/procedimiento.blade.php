@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Procedimiento</center></h3>@stop
@section('content')
@include('alerts.request')

<!-- DROPZONE  -->
{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->

{!!Html::script('js/procedimiento.js')!!}

<?php
  //Se pregunta  si existe el id de acta de capacitacion  para saber si existe o que devuelva un 0 (se le envia la variable al dropzone )
  $idProcedimientos = (isset($procedimiento) ? $procedimiento->idProcedimiento : 0);

?>
  <script>



    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

    var idDocumentoSoporte = '<?php echo isset($idDocumentoSoporte) ? $idDocumentoSoporte : "";?>';
    var nombreDocumentoSoporte = '<?php echo isset($nombreDocumentoSoporte) ? $nombreDocumentoSoporte : "";?>';

    var tercero = [idTercero != '' ? JSON.parse(idTercero) : '', 
                   nombreCompletoTercero != '' ? JSON.parse(nombreCompletoTercero) : ''];
    var documentosoporte = [idDocumentoSoporte != '' ? JSON.parse(idDocumentoSoporte) : '', 
                            nombreDocumentoSoporte != '' ? JSON.parse(nombreDocumentoSoporte) : ''];


    var procedimientoDetalle = '<?php echo (isset($procedimiento) ? json_encode($procedimiento->procedimientoDetalle) : "");?>';
    procedimientoDetalle = (procedimientoDetalle != '' ? JSON.parse(procedimientoDetalle) : '');

    var valorProcedimiento = ['',0,0];

    $(document).ready(function(){


      procedimiento = new Atributos('procedimiento','contenedor_procedimiento','procedimiento_');
      procedimiento.campos    = ['actividadProcedimientoDetalle', 'Tercero_idResponsable',        'Documento_idDocumento'];
      procedimiento.etiqueta  = ['input',                          'select',                       'select'];
      procedimiento.tipo      = ['text',                              '',                             ''];
      procedimiento.estilo    = ['width: 900px;height:35px;',     'width: 300px;height:35px;display:inline-block','width: 300px;height:35px;display:inline-block'];
      procedimiento.clase     = ['',                              'chosen-select form-control',   'chosen-select form-control'];
      procedimiento.opciones  = ['',tercero,documentosoporte]; 
      procedimiento.sololectura = [false,false,false];
      var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"]; 
      procedimiento.funciones  = [quitacarac,'','']; 
      // procedimiento.nombreCompletoTercero =  JSON.parse(nombreCompletoTercero);
      // procedimiento.idTercero =  JSON.parse(idTercero);
      // procedimiento.nombreDocumentoSoporte =  JSON.parse(nombreDocumentoSoporte);
      // procedimiento.idDocumentoSoporte =  JSON.parse(idDocumentoSoporte);


      for(var j=0, k = procedimientoDetalle.length; j < k; j++)
      {
        procedimiento.agregarCampos(JSON.stringify(procedimientoDetalle[j]),'L');
      }
      document.getElementById('registros').value = j ;
    });

  </script>

  @if(isset($procedimiento))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($procedimiento,['route'=>['procedimiento.destroy',$procedimiento->idProcedimiento],'method'=>'DELETE', 'files' => true])!!}
    @else
      {!!Form::model($procedimiento,['route'=>['procedimiento.update',$procedimiento->idProcedimiento],'method'=>'PUT', 'files' => true])!!}
    @endif
  @else
    {!!Form::open(['route'=>'procedimiento.store','method'=>'POST'])!!}
  @endif

<div id='form-section' >

  <fieldset id="procedimiento-form-fieldset"> 
      <div class="form-group" id='test'>
          {!!Form::label('Proceso_idProceso', 'Proceso ', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
                  <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-flag"></i>
                      </span>
              {!!Form::select('Proceso_idProceso',$procesos, (isset($procedimiento) ? $procedimiento->Proceso_idProceso : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Proceso"])!!}
              {!! Form::hidden('idProcedimiento', null, array('id' => 'idProcedimiento')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}

            </div>
          </div>
        </div>


        <div class="form-group" id='test'>
          {!!Form::label('nombreProcedimiento', 'Procedimiento', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('nombreProcedimiento',null, ['class'=>'form-control', 'placeholder'=>'Ingresa el nombre del procedimiento', 'style'=>'width:340;',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaElaboracionProcedimiento', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaElaboracionProcedimiento',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
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
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Objetivos</a>
                        </h4>
                      </div>
                      <div id="collapseOne" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('objetivoProcedimiento',null,['class'=>'ckeditor','placeholder'=>'Especfica los objetivos del procedimiento'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Alcance</a>
                        </h4>
                      </div>
                      <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                              <div class="col-sm-10">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square-o "></i>
                                  </span>
                                  {!!Form::textarea('alcanceProcedimiento',null,['class'=>'ckeditor','placeholder'=>'Especfica el alcance del procedimiento'])!!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Responsabilidades</a>
                        </h4>
                      </div>
                      <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('responsabilidadProcedimiento',null,['class'=>'ckeditor','placeholder'=>'Especfica las responsabilidades del procedimiento'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Generalidades</a>
                        </h4>
                      </div>
                      <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                          <div class="form-group" id='test'>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('generalidadProcedimiento',null,['class'=>'ckeditor','placeholder'=>''])!!}
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#archivos">Archivos</a>
                      </h4>
                    </div>
                    <div id="archivos" class="panel-collapse collapse">
                      <div class="col-sm-12">
                        <!-- <div class="panel panel-default">  SE QUITA POR PETICION DE ANDRES-->  <!--se cambia la clase panel-primary AZUL por default para que salga gris   -->
                                          <div class="panel-heading ">
                                              <!-- <i class="fa fa-pencil-square-o"></i> --> <!-- {!!Form::label('', 'Documentos', array())!!} -->
                                          </div>
                                          <div class="panel-body">
                            <div class="col-sm-12">
                              <div id="upload" class="col-md-12">
                                  <div class="dropzone dropzone-previews" id="dropzoneProcedimientoArchivo" style="overflow: auto;">
                                  </div>  
                              </div>  
                            
                              
                              <div class="col-sm-12" style="padding: 10px 10px 10px 10px;border: 1px solid; height:300px;overflow: auto;">   
                              {!!Form::hidden('archivoProcedimientoArray', '', array('id' => 'archivoProcedimientoArray'))!!}
                                <?php
                                
                                //Cuando este editando el archivo 
                                if ($idProcedimientos != '')  //Se pregunta si el id de  procedimiento es diferente de vacio (que es la tabla papá)
                                {
                                  $eliminar = '';
                                  $archivoSave = DB::Select('SELECT * from procedimientoarchivo where Procedimiento_idProcedimiento = '.$idProcedimientos);
                                  for ($i=0; $i <count($archivoSave) ; $i++) 
                                  { 
                                    $archivoS = get_object_vars($archivoSave[$i]);

                                    echo '<div id="'.$archivoS['idProcedimientoArchivo'].'" class="col-lg-4 col-md-4">
                                                <div class="panel panel-yellow" style="border: 1px solid orange;">
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-3">
                                                                <a target="_blank" 
                                                                  href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$archivoS['rutaProcedimientoArchivo'].'">
                                                                  <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                                </a>
                                                            </div>

                                                            <div class="col-xs-9 text-right">
                                                                <div>'.str_replace('/procedimiento/','',$archivoS['rutaProcedimientoArchivo']).'
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a target="_blank" href="javascript:eliminarDiv('.$archivoS['idProcedimientoArchivo'].');">
                                                        <div class="panel-footer">
                                                            <span class="pull-left">Eliminar Documento</span>
                                                            <span class="pull-right"><i class="fa fa-times"></i></span>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>';

                                    echo '<input type="hidden" id="idProcedimientoArchivo[]" name="idProcedimientoArchivo[]" value="'.$archivoS['idProcedimientoArchivo'].'" >

                                    <input type="hidden" id="rutaProcedimientoArchivo[]" name="rutaProcedimientoArchivo[]" value="'.$archivoS['rutaProcedimientoArchivo'].'" >';
                                  }

                                  echo '<input type="hidden" name="eliminarArchivo" id="eliminarArchivo" value="">';
                                }
                                
                                 ?>             
                              </div>
                            </div>
                          </div>
                        <!-- </div> -->
                      </div>
                    </div>
                  </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="panel-body" style="width:1220px;" >
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid" style=" border: 1px solid #C0C0C0;">
                  <div style="overflow:auto; height:350px;">
                    <div style="width: 1550px; display: inline-block;">
                      <div class="col-md-1" style="width: 40px;" onclick="procedimiento.agregarCampos(valorProcedimiento,'A')">
                        <span class="glyphicon glyphicon-plus"></span>
                      </div>
                      <div class="col-md-1" style="width: 900px;">Actividad</div>
                      <div class="col-md-1" style="width: 300px;">Responsable</div>
                      <div class="col-md-1" style="width: 300px;">Documento y/o Registro</div>
                      <div id="contenedor_procedimiento">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>
  @if(isset($procedimiento))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @else
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'habilitarSubmit(event);'])!!}
  @endif
  {!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
        $('#fechaElaboracionProcedimiento').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    
    CKEDITOR.replace(('objetivoProcedimiento','alcanceProcedimiento','responsabilidadProcedimiento','generalidadProcedimiento'), {
        fullPage: true,
        allowedContent: false
    });

  </script>


  </div>
</div>
<script>


    //--------------------------------- DROPZONE ---------------------------------------
  var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneProcedimientoArchivo", {
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

    document.getElementById('archivoProcedimientoArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
              //abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
            // console.log(fileList);
                        document.getElementById('archivoProcedimientoArray').value += file.name+',';
                        // console.log(document.getElementById('archivoProcedimientoArray').value);
                        i++;
                    });

</script>

@stop