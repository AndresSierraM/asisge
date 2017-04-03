@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Procedimiento</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::script('js/procedimiento.js')!!}
  <script>
    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

    var idDocumentoSoporte = '<?php echo isset($idDocumentoSoporte) ? $idDocumentoSoporte : "";?>';
    var nombreDocumentoSoporte = '<?php echo isset($nombreDocumentoSoporte) ? $nombreDocumentoSoporte : "";?>';

    var procedimientoDetalle = '<?php echo (isset($procedimiento) ? json_encode($procedimiento->procedimientoDetalle) : "");?>';
    procedimientoDetalle = (procedimientoDetalle != '' ? JSON.parse(procedimientoDetalle) : '');
    var valorProcedimiento = ['',0,0];

    $(document).ready(function(){


      procedimiento = new Atributos('procedimiento','contenedor_procedimiento','procedimiento_');
      procedimiento.campos    = ['actividadProcedimientoDetalle', 'Tercero_idResponsable',        'Documento_idDocumento'];
      procedimiento.etiqueta  = ['input',                          'select1',                       'select2'];
      procedimiento.tipo      = ['text',                              '',                             ''];
      procedimiento.estilo    = ['width: 900px;height:35px;',     'width: 300px;height:30px;','width: 300px;height:30px;'];
      procedimiento.clase     = ['',                              'chosen-select form-control',   'chosen-select form-control'];
      procedimiento.sololectura = [false,false,false];
      var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"]; 
      procedimiento.funciones  = [quitacarac,'','']; 
      procedimiento.nombreCompletoTercero =  JSON.parse(nombreCompletoTercero);
      procedimiento.idTercero =  JSON.parse(idTercero);
      procedimiento.nombreDocumentoSoporte =  JSON.parse(nombreDocumentoSoporte);
      procedimiento.idDocumentoSoporte =  JSON.parse(idDocumentoSoporte);


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
              {!!Form::text('nombreProcedimiento',null, ['class'=>'form-control', 'placeholder'=>'Ingresa el nombre del procedimiento', 'style'=>'width:340;'])!!}
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

                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="panel-body" style="width:1220px;">
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
@stop