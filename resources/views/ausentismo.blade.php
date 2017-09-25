@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Ausentismos</center></h3>@stop

@section('content')
{!!Html::script('js/ausentismo.js')!!}

@include('alerts.request')

	@if(isset($ausentismo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($ausentismo,['route'=>['ausentismo.destroy',$ausentismo->idAusentismo],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($ausentismo,['route'=>['ausentismo.update',$ausentismo->idAusentismo],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'ausentismo.store','method'=>'POST', 'files' => true])!!}
	@endif

	<?php $mytime = Carbon\Carbon::now();?>
		<div id='form-section' >
				<fieldset id="ausentismo-form-fieldset">	

				<div class="form-group required" id='test'>
					{!!Form::label('Tercero_idTercero', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
							{!!Form::select('Tercero_idTercero',$tercero, (isset($ausentismo) ? $ausentismo->Tercero_idTercero : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Empleado"])!!}
						</div>
					</div>
				</div>

				<div class="form-group required" id='test'>
					{!!Form::label('nombreAusentismo', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('nombreAusentismo',null,['class'=>'form-control','placeholder'=>'Ingresa la descripcion del ausentismo'])!!}
					      	{!!Form::hidden('idAusentismo', null, array('id' => 'idAusentismo'))!!}
						</div>
					</div>
				</div>
				<div class="form-group required" id='test'>
					{!!Form::label('tipoAusentismo', 'Tipo de Ausencia', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o"></i>
			              	</span>
							{!!Form::select('tipoAusentismo',
							array(
							'Calamidad Domestica' => 'Calamidad Domestica',
							'Ausencia Laboral No Justificada' => 'Ausencia Laboral No Justificada',
							'Suspension' => 'Suspension',
							'Permiso Remunerado' => 'Permiso Remunerado',
							'Permiso No Remunerado' => 'Permiso No Remunerado',
							'Ley de Duelo' => 'Ley de Duelo',
							'Suspension Temporal del Contrato de Trabajo' => 'Suspension Temporal del Contrato de Trabajo',
							'Enfermedad General' => 'Enfermedad General',
							'Enfermedad Laboral' => 'Enfermedad Laboral',
							'Accidente de Trabajo' => 'Accidente de Trabajo',
							'Incidente de Trabajo' => 'Incidente de Trabajo'
							),
							(isset($ausentismo) ? $ausentismo->tipoAusentismo : 0),
							['class'=>'form-control','placeholder'=>'Ingresa el tipo de ausencia'])!!}
			    		</div>
			    	</div>
			    </div>	


		        <div class="form-group required" id='test'>
		          {!!Form::label('fechaElaboracionAusentismo', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
		              {!!Form::text('fechaElaboracionAusentismo',(isset($ausentismo) ? $ausentismo->fechaElaboracionAusentismo : $mytime->toDateTimeString()), ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
		            </div>
		          </div>
		        </div>

		        <div class="form-group required" id='test'>
		          {!!Form::label('fechaInicioAusentismo', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
		              {!!Form::text('fechaInicioAusentismo',null, ['onblur' => 'calcularDiasAusencia(this.value, document.getElementById(\'fechaFinAusentismo\').value)', 'class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Inicio', 'style'=>'width:340;'])!!}
		            </div>
		          </div>
		        </div>

		        <div class="form-group required" id='test'>
		          {!!Form::label('fechaFinAusentismo', 'Fecha Fin', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
		              {!!Form::text('fechaFinAusentismo',null, ['onblur' => 'calcularDiasAusencia( document.getElementById(\'fechaInicioAusentismo\').value,this.value)', 'class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Fin', 'style'=>'width:340;'])!!}
		            </div>
		          </div>
		        </div>
		        <div class="form-group" id='test'>
					{!!Form::label('diasAusentismo', 'D&iacute;as', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('diasAusentismo',null,['readonly' => 'readonly', 'class'=>'form-control'])!!}
						</div>
					</div>
				</div>
		        <div class="form-group"  >
		        {!! Form::label('archivoAusentismo', 'Soporte de la Ausencia', array('class' => 'col-sm-2 control-label')) !!}
		          	<div class="col-sm-10" >
			            <div class="panel panel-default">
			            <!-- En el create va a salir, para adjuntar el archivo-->
			            <input id="archivoAusentismo" name="archivoAusentismo" type="file" value="<?php echo ((isset($ausentismo->archivoAusentismo) and $ausentismo->archivoAusentismo != '') ? 'imagenes/'. $ausentismo->archivoAusentismo : ''); ?>" >
			            </div>
		          	</div>
		        </div>
		   


				</fieldset>	
				@if(isset($ausentismo))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script type="text/javascript">
    $('#fechaElaboracionAusentismo').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    $('#fechaInicioAusentismo').datetimepicker(({
    	format: "YYYY-MM-DD HH:mm:ss"
    }));

    $('#fechaFinAusentismo').datetimepicker(({
	   	format: "YYYY-MM-DD HH:mm:ss"
    }));

        

</script>

@stop


