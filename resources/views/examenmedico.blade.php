@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Examenes M&eacute;dicos</center></h3>@stop
@section('content')
@include('alerts.request')

{!!Html::script('js/examenmedico.js')!!}
  <script>

    var examenmedicoDetalle = '<?php echo (isset($examenesmedicos) ? json_encode($examenesmedicos) : "");?>';

    examenmedicoDetalle = (examenmedicoDetalle != '' ? JSON.parse(examenmedicoDetalle) : '');
    var valorExamenMedico = [0,'','','','',''];

    $(document).ready(function(){

        // ejecutamos la funcion para llenar el cargo del empleado
        CargarCargo(document.getElementById('Tercero_idTercero').value);

        // creamos los campos del detalle por cada pregunta, en los cuales solo se llenan 3 campos
        // puntuacion (digitado por el susuario de 1 a 5 )
        // resultado, calculado por el sistema (resultado = puntuacion * 20  expresado como porcentaje)
        // mejora (digitado por le usuario, editor de texto libre)
        examenmedico = new Atributos('detalle','contenedor_detalle','detalle_');
        examenmedico.campos   = ['TipoExamenMedico_idTipoExamenMedico',  'nombreTipoExamenMedico', 
                                'limiteInferiorTipoExamenMedico' , 'limiteSuperiorTipoExamenMedico',
                                'resultadoExamenMedicoDetalle',   'observacionExamenMedicoDetalle'];
        examenmedico.etiqueta = ['input', 'input', 'input', 'input', 'input', 'textarea'];
        examenmedico.tipo     = ['hidden', 'text', 'text','text','text' , 'textarea'];
        examenmedico.estilo   = ['',
                                'vertical-align:top; width: 400px; height:35px;', 
                                'vertical-align:top; width: 150px;  height:35px;',
                                'vertical-align:top; width: 150px;  height:35px;',
                                'vertical-align:top; width: 170px;  height:35px;',
                                'vertical-align:top; resize:none; width: 300px; height:35px;'];
        examenmedico.clase    = ['','','','','',''];
        examenmedico.sololectura = [false,true,true,true,false,false];
      
        examenmedico.opciones = ['','','','','',''];


        // hacemos un rompimiento de control para agrupar las preguntas
        for(var j=0, k = examenmedicoDetalle.length; j < k; j++)
        {
          // llena los campos de preguntas
          examenmedico.agregarCampos(JSON.stringify(examenmedicoDetalle[j]),'L');
        }
        document.getElementById('registros').value = j ;
    });

  </script>

	@if(isset($examenmedico))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($examenmedico,['route'=>['examenmedico.destroy',$examenmedico->idExamenMedico],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($examenmedico,['route'=>['examenmedico.update',$examenmedico->idExamenMedico],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'examenmedico.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<fieldset id="examenmedico-form-fieldset">	

        <div class="form-group" id='test'>
          {!!Form::label('Tercero_idTercero', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              {!!Form::select('Tercero_idTercero',$tercero, (isset($examenmedico) ? $examenmedico->Tercero_idTercero : 0),
                  ["onchange" => "CargarCargo(this.value)",
                   "class" => "chosen-select form-control", 
                   "placeholder" =>"Seleccione el empleado a quien se realizan los examenes"
                  ])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('nombreCargo', 'Cargo', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!! Form::text('nombreCargo',null, ['id' => 'nombreCargo', 'readonly' => 'readonly', 'class'=>'form-control', 'placeholder'=>'Cargo del empleado', 'style'=>'width:340;']) !!}
              {!! Form::hidden('idCargo', null, array('id' => 'idCargo')) !!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaExamenMedico', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaExamenMedico',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('tipoExamenMedico', 'Tipo de Examen', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
              
              {!!Form::select('tipoExamenMedico',
                      array('Ingreso'=>'Ingreso',
                      'Retiro'=>'Retiro',
                      'Periodico'=>'Peri&oacute;dico'), 
                      (isset($examenmedico) ? $examenmedico->tipoExamenMedico : 0),
                      ["onchange" => "CargarExamenes(document.getElementById('Tercero_idTercero').value, document.getElementById('idCargo').value, this.value)",
                       "class" => "chosen-select form-control", 
                       "placeholder" =>"Seleccione el tipo de examen"
                      ])!!}

              {!! Form::hidden('idExamenMedico', null, array('id' => 'idExamenMedico')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}
            </div>
          </div>
        </div>

        <div class="panel-body">
          <div class="form-group" id='test'>

            <div class="col-sm-12">
              <div class="row show-grid">
                <div style="overflow: auto; width: 100%;">
  
                    <div class="col-md-1" style="width: 400px;">Examen</div>
                    <div class="col-md-2" style="width: 150px;">Lim. Inferior</div>
                    <div class="col-md-3" style="width: 150px;">Lim. Superior</div>
                    <div class="col-md-4" style="width: 170px;">Resultado</div>
                    <div class="col-md-5" style="width: 300px;">Observaci&oacute;n</div>
                 
                    <div id="contenedor_detalle">
                    </div>

                </div>
              </div>
            </div>


            
          </div>
        </div>
    </fieldset>
	@if(isset($examenmedico))
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
        $('#fechaExamenMedico').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

  </script>


	</div>
</div>
@stop