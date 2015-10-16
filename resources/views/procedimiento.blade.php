@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Procedimiento</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::script('js/procedimiento.js')!!}
  <script>
    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

    var idDocumento = '<?php echo isset($idDocumento) ? $idDocumento : "";?>';
    var nombreDocumento = '<?php echo isset($nombreDocumento) ? $nombreDocumento : "";?>';

    var procedimientoDetalle = '<?php echo (isset($procedimiento) ? json_encode($procedimiento->procedimientoDetalle) : "");?>';
    procedimientoDetalle = (procedimientoDetalle != '' ? JSON.parse(procedimientoDetalle) : '');
    var valorProcedimiento = ['',0,0];

    $(document).ready(function(){


      procedimiento = new Atributos('procedimiento','contenedor_procedimiento','procedimiento_');
      procedimiento.campos    = ['actividadProcedimientoDetalle', 'Tercero_idResponsable',        'Documento_idDocumento'];
      procedimiento.etiqueta  = ['input',                          'select1',                       'select2'];
      procedimiento.tipo      = ['text',                              '',                             ''];
      procedimiento.estilo    = ['width: 500px;height:35px;',     'width: 300px;height:30px;','width: 300px;height:30px;'];
      procedimiento.clase     = ['',                              'chosen-select form-control',   'chosen-select form-control'];
      procedimiento.sololectura = [false,false,false];
      procedimiento.nombreCompletoTercero =  JSON.parse(nombreCompletoTercero);
      procedimiento.idTercero =  JSON.parse(idTercero);
      procedimiento.nombreDocumento =  JSON.parse(nombreDocumento);
      procedimiento.idDocumento =  JSON.parse(idDocumento);


      for(var j=0, k = procedimientoDetalle.length; j < k; j++)
      {
        procedimiento.agregarCampos(JSON.stringify(procedimientoDetalle[j]),'L');
      }

    });

  </script>

	@if(isset($procedimiento))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($procedimiento,['route'=>['procedimiento.destroy',$procedimiento->idProcedimiento],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($procedimiento,['route'=>['procedimiento.update',$procedimiento->idProcedimiento],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'procedimiento.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<fieldset id="procedimiento-form-fieldset">	
	    <div class="form-group" id='test'>
          {!!Form::label('Proceso_idProceso', 'Procedimiento de ', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
                  <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-flag"></i>
                      </span>
              {!!Form::select('Proceso_idProceso',$procesos, (isset($procedimiento) ? $procedimiento->Proceso_idProceso : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Proceso"])!!}
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
                                {!!Form::textarea('objetivoProcedimiento',null,['class'=>'form-control','placeholder'=>'Especfica los objetivos del procedimiento'])!!}
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
                                  {!!Form::textarea('alcanceProcedimiento',null,['class'=>'form-control','placeholder'=>'Especfica el alcance del procedimiento'])!!}
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
                                {!!Form::textarea('responsabilidadProcedimiento',null,['class'=>'form-control','placeholder'=>'Especfica las responsabilidades del procedimiento'])!!}
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

        <div class="panel-body">
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid">
                <div class="col-md-1" style="width: 40px;" onclick="procedimiento.agregarCampos(valorProcedimiento,'A')">
                  <span class="glyphicon glyphicon-plus"></span>
                </div>
                <div class="col-md-1" style="width: 500px;">Actividad</div>
                <div class="col-md-1" style="width: 300px;">Responsable</div>
                <div class="col-md-1" style="width: 300px;">Documento y/o Registro</div>
                <div id="contenedor_procedimiento">
                </div>
              </div>
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($procedimiento))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif
	{!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
        $('#fechaElaboracionProcedimiento').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

  </script>


	</div>
</div>
@stop