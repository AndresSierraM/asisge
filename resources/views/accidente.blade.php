@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Accidentes</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($accidente))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($accidente,['route'=>['accidente.destroy',$accidente->idAccidente],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($accidente,['route'=>['accidente.update',$accidente->idAccidente],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'accidente.store','method'=>'POST', 'files' => true])!!}
	@endif

	<?php $mytime = Carbon\Carbon::now();?>

		<div id='form-section' >
				<fieldset id="accidente-form-fieldset">	

				<div class="form-group" id='test'>
					{!!Form::label('numeroAccidente', 'N&uacute;mero', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('numeroAccidente',null,['class'=>'form-control','placeholder'=>'Ingresa el número del accidente'])!!}
					      	{!!Form::hidden('idAccidente', null, array('id' => 'idAccidente'))!!}
						</div>
					</div>
				</div>

				<div class="form-group" id='test'>
					{!!Form::label('nombreAccidente', 'Descripci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-barcode"></i>
			              	</span>
							{!!Form::text('nombreAccidente',null,['class'=>'form-control','placeholder'=>'Ingresa la descripcion del accidente'])!!}
						</div>
					</div>
				</div>

				<div class="form-group" id='test'>
					{!!Form::label('clasificacionAccidente', 'Clase de Accidente', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-pencil-square-o"></i>
			              	</span>
							{!!Form::select('clasificacionAccidente',
							array(
							'Accidente Normal' => 'Accidente Normal',
							'Accidente Grave' => 'Accidente Grave',
							'Accidente Mortal' => 'Accidente Mortal',
							'Incidente' => 'Incidente',
							'Incidente No Caracterizado' => 'Incidente No Caracterizado'
							),
							(isset($accidente) ? $accidente->clasificacionAccidente : 0),
							['class'=>'form-control','placeholder'=>'Ingresa la clasificaci&oacute;n del accidente'])!!}
			    		</div>
			    	</div>
			    </div>	




				<div class="form-group" id='test'>
					{!!Form::label('Tercero_idCoordinador', 'Coord. Investigaci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
							{!!Form::select('Tercero_idCoordinador',$tercero, (isset($accidente) ? $accidente->Tercero_idCoordinador : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Coordinador del equipo de investigaci&oacute;n"])!!}
						</div>
					</div>
				</div>

		<div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#empleado">Datos Generales del Trabajador</a>
                      </h4>
                    </div>
                    <div id="empleado" class="panel-collapse collapse">
						<div class="panel-body">

							<div class="form-group" id='test'>
					          {!!Form::label('enSuLaborAccidente', 'Oficio habitual', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::checkbox('enSuLaborAccidente',(isset($accidente) ? $accidente->enSuLaborAccidente : 0), ['class'=>'form-control', 'style'=>'width:30px;height: 30px;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('enLaEmpresaAccidente', 'En la Empresa', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::checkbox('enLaEmpresaAccidente',(isset($accidente) ? $accidente->enLaEmpresaAccidente : 0), ['class'=>'form-control', 'style'=>'width:30px;height: 30px;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('lugarAccidente', 'Lugar', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('lugarAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa el lugar del accidente', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

						</div>
			        </div>                           
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#accidente">Datos Generales Sobre el Accidente</a>
                      </h4>
                    </div>
                    <div id="accidente" class="panel-collapse collapse">
						<div class="panel-body">

					        <div class="form-group" id='test'>
					          {!!Form::label('fechaOcurrenciaAccidente', 'Fecha/Hora', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('fechaOcurrenciaAccidente',(isset($accidente) ? $accidente->fechaOcurrenciaAccidente : $mytime->toDateTimeString()), ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Ocurrencia', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('tiempoEnLaborAccidente', 'Tiempo en Labor', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('tiempoEnLaborAccidente',null,  ['class'=>'form-control', 'placeholder'=>'Ingresa el tiempo desempeñando la labor', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('tareaDesarrolladaAccidente', 'Lugar', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
					              {!!Form::text('tareaDesarrolladaAccidente', null, ['class'=>'form-control', 'placeholder'=>'Ingresa la tarea desarrollada al momento del accidente', 'style'=>'width:340;'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('descripcionAccidente', 'Descripcion Ampliada', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('descripcionAccidente',null,['class'=>'ckeditor','placeholder'=>'Ampliación de la descripción del accidente (describa donde, que y cómo ocurrió)'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('observacionTrabajadorAccidente', 'Observaciones Trabajador', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('observacionTrabajadorAccidente',null,['class'=>'ckeditor','placeholder'=>'Observaciones del trabajador y/o testigos'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('observacionEmpresaAccidente', 'Observaciones Empresa', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('observacionEmpresaAccidente',null,['class'=>'ckeditor','placeholder'=>'Observaciones de la empresa (equipo de salud ocupacional, jefe inmediato y copaso)'])!!}
					            </div>
					          </div>
					        </div>

						</div>
			        </div>   
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#analisis">An&aacute;lisis del Accidente o Incidente</a>
                      </h4>
                    </div>
                    <div id="analisis" class="panel-collapse collapse">
						<div class="panel-body">

					        <div class="form-group" id='test'>
					          {!!Form::label('agenteYMecanismoAccidente', 'Agente y Mecanismo', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('agenteYMecanismoAccidente',null,['class'=>'ckeditor','placeholder'=>'Agente y mecanismo del accidente'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('naturalezaLesionAccidente', 'Naturaleza de la Lesi&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('naturalezaLesionAccidente',null,['class'=>'ckeditor','placeholder'=>'Naturaleza de la Lesi&oacute;n'])!!}
					            </div>
					          </div>
					        </div>

					        <div class="form-group" id='test'>
					          {!!Form::label('parteCuerpoAfectadaAccidente', 'Parte del cuerpo afectada', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('parteCuerpoAfectadaAccidente',null,['class'=>'ckeditor','placeholder'=>'Parte del cuerpo afectada'])!!}
					            </div>
					          </div>
					        </div>


					        <div class="form-group" id='test'>
					          {!!Form::label('tipoAccidente', 'Tipo de Accidente', array('class' => 'col-sm-2 control-label'))!!}
					          <div class="col-sm-10" >
					            <div class="input-group">
					              <span class="input-group-addon">
					                <i class="fa fa-calendar" ></i>
					              </span>
                              		{!!Form::textarea('tipoAccidente',null,['class'=>'ckeditor','placeholder'=>'Tipo de Accidente'])!!}
					            </div>
					          </div>
					        </div>
					    </div>
			        </div> 
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#politicas">Recomendaciones para la Intervencion de las Causas Encontradas en el Analisis, Evaluación Y Control</a>
                      </h4>
                    </div>
                    <div id="politicas" class="panel-collapse collapse">
                      <div class="panel-body">

                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#principios">Participantes de la Investigaci&oacute;n</a>
                      </h4>
                    </div>
            
                  </div>
                   <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#metas">Notas</a>
                      </h4>
                    </div>
                    <div id="metas" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('observacionAccidente',null,['class'=>'ckeditor','placeholder'=>'Ingresa otras observaciones del accidente'])!!}
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
				@if(isset($accidente))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script type="text/javascript">
    $('#fechaOcurrenciaAccidente').datetimepicker(({
      format: "YYYY-MM-DD"
    }));
</script>

@stop