@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Examenes M&eacute;dicos</center></h3>@stop
@section('content')
@include('alerts.request')

{!!Html::script('js/examenmedico.js')!!}
{!!Html::style('css/image-pad.css'); !!} 
  <script>

    var examenmedicoDetalle = '<?php echo (isset($examenesmedicos) ? json_encode($examenesmedicos) : "");?>';

    examenmedicoDetalle = (examenmedicoDetalle != '' ? JSON.parse(examenmedicoDetalle) : '');

    valorResultado =  Array("Apto", "No Apto");
    nombreResultado =  Array("Apto", "No Apto");

    var resultado = [valorResultado,nombreResultado];

    var valorExamenMedico = [0,'','',''];

    $(document).ready(function(){

        examenmedico = new Atributos('detalle','contenedor_detalle','detalle_');
        // como este formulario no lleva caneca para eliminar registros de detalle, no llenamos las
        // propiedades correspondientes
        examenmedico.altura = '62px;';
        examenmedico.campoid = '';
        examenmedico.campoEliminacion = '';
        examenmedico.botonEliminacion = false;

        // ejecutamos la funcion para llenar el cargo del empleado
        if(document.getElementById('Tercero_idTercero').value != 0)
          CargarCargo(document.getElementById('Tercero_idTercero').value);

        // creamos los campos del detalle por cada pregunta, en los cuales solo se llena 1 campo
        // una lista de selección "apto" o "no apto"
        
        examenmedico.campos   = [
        'idExamenMedicoDetalle',
        'TipoExamenMedico_idTipoExamenMedico', 
        'nombreTipoExamenMedico',  
        'resultadoExamenMedicoDetalle', 
        'archivoExamenMedicoDetalle',
        'fotoExamenMedicoDetalle', 
        'observacionExamenMedicoDetalle'];
        
        examenmedico.etiqueta = ['input','input', 'input', 'select', 'file', 'imagen','textarea'];

        examenmedico.tipo     = ['hidden','hidden', 'text', '', '', 'imagen', 'textarea'];
        
        examenmedico.estilo   = ['','',
                                'vertical-align:top; width: 300px; height:60px;', 
                                'vertical-align:top; width: 110px;  height:60px;',
                                'vertical-align:top; width: 200px;  height:60px; display: inline-block;',
                                'vertical-align:top; width: 60px;  height:60px; display: inline-block;',
                                'vertical-align:top; resize:none; width: 300px; height:60px;'];

        examenmedico.clase    = ['','','','','','btn-primary',''];

        examenmedico.sololectura = [false,false,true,false,false,false,false];
      
        examenmedico.opciones = ['','','',resultado,'','',''];
        var quitacarac = ["onchange","this.value=quitarCaracterEspecial(this.value);"];
        examenmedico.funciones ['','','','','','',quitacarac];

        document.getElementById('registros').value = 0 ;
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

  <div id="image-pad" class="m-image-pad" style="height: 100%; width: 100% left; display: none;">
    <input type="hidden" id="image-reg" value="">
      <div class="m-image-pad--body">
        <img id="image-src"></img>
      </div>
      <div class="m-image-pad--footer">
        <div class="description">Vista previa de la imagen</div>
        <button type="button" class="button clear btn btn-primary" onclick="document.getElementById('image-pad').style.display = 'none';">Cerrar</button>
      </div>
  </div>

	<fieldset id="examenmedico-form-fieldset">	

        <div class="form-group required" id='test'>
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

        <div class="form-group required" id='test'>
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

        <div class="form-group required" id='test'>
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
  
                    <div class="col-md-1" style="width: 300px;height: 44px;">Examen</div>
                    <div class="col-md-4 requiredMulti" style="width: 110px;height: 44px;">Resultado</div>
                    <div class="col-md-4" style="width: 260px;height: 44px;">Evidencia Fotogr&aacute;fica</div>
                    <div class="col-md-5" style="width: 300px;height: 44px;">Observaci&oacute;n</div>
                 
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

    $(document).ready(function()
    {
      mostrarImagen();
    });

  </script>


	</div>
</div>

{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}
@stop