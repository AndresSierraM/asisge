@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Acta de Reunión<br>Grupo de Apoyo</center></h3>@stop

@section('content')
@include('alerts.request')

	<script>
		var actaGrupoApoyoTema = '<?php echo (isset($actaGrupoApoyo) ? json_encode($actaGrupoApoyo->actaGrupoApoyoTema) : "");?>';
		actaGrupoApoyoTema = (actaGrupoApoyoTema != '' ? JSON.parse(actaGrupoApoyoTema) : '');

		var actaGrupoApoyoTercero = '<?php echo (isset($actaGrupoApoyo) ? json_encode($actaGrupoApoyo->actaGrupoApoyoTercero) : "");?>';
		actaGrupoApoyoTercero = (actaGrupoApoyoTercero != '' ? JSON.parse(actaGrupoApoyoTercero) : '');

		var valorTercero = [0,0];
		var valorTema = [0,'','',0,''];

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

		$(document).ready(function(){

			participante = new Atributos('participante','contenedor_participante','participante_');
			participante.campos = ['idActaGrupoApoyoTercero', 'Tercero_idParticipante'];
			participante.etiqueta = ['input','select'];
			participante.tipo = ['hidden',''];
			participante.estilo = ['','width: 1010px;height:35px;'];
			participante.clase = ['',''];
			participante.sololectura = [false,false];
			participante.completar = ['off','off'];
			participante.opciones = ['',tercero];
			participante.funciones  = ['',''];

				
			tema = new Atributos('tema','contenedor_tema','tema_');
			tema.campos = ['idActaGrupoApoyoTema', 'temaActaGrupoApoyoTema', 'desarrolloActaGrupoApoyoTema','Tercero_idResponsable','observacionActaGrupoApoyoTema'];
			tema.etiqueta = ['input', 'input','input','select','input'];
			tema.tipo = ['hidden','','','',''];
			tema.estilo = ['','width: 300px;height:35px;','width: 300px;height:35px;','width: 200px;height:35px;','width: 200px;height:35px;'];
			tema.clase = ['','','','',''];
			tema.sololectura = [false,false,false,false,false];
			tema.completar = ['off','off','off','off','off'];
			tema.opciones = ['','','',tercero,''];
			tema.funciones  = ['','','','',''];


			for(var j=0, k = actaGrupoApoyoTercero.length; j < k; j++)
			{
				participante.agregarCampos(JSON.stringify(actaGrupoApoyoTercero[j]),'L');
			}

				
			for(var j=0, k = actaGrupoApoyoTema.length; j < k; j++)
			{
				tema.agregarCampos(JSON.stringify(actaGrupoApoyoTema[j]),'L');
			}

		 });

	</script>

	@if(isset($actaGrupoApoyo))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($actaGrupoApoyo,['route'=>['actagrupoapoyo.destroy',$actaGrupoApoyo->idActaGrupoApoyo],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($actaGrupoApoyo,['route'=>['actagrupoapoyo.update',$actaGrupoApoyo->idActaGrupoApoyo],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'actagrupoapoyo.store','method'=>'POST'])!!}
	@endif

	<?php $mytime = Carbon\Carbon::now();?>
		<div id='form-section' >
				<fieldset id="actagrupoapoyo-form-fieldset">	

				<div class="form-group" id='test'>
					{!!Form::label('GrupoApoyo_idGrupoApoyo', 'Grupo de Apoyo', array('class' => 'col-sm-2 control-label'))!!}
					<div class="col-sm-10">
			            <div class="input-group">
			              	<span class="input-group-addon">
			                	<i class="fa fa-flag"></i>
			              	</span>
							{!!Form::select('GrupoApoyo_idGrupoApoyo',$grupoapoyo, (isset($actaGrupoApoyo) ? $actaGrupoApoyo->GrupoApoyo_idGrupoApoyo : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el Grupo de Apoyo"])!!}
						</div>
					</div>
				</div>

		        <div class="form-group" id='test'>
		          {!!Form::label('fechaActaGrupoApoyo', 'Fecha Reuni&oacute;', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
		              {!!Form::text('fechaActaGrupoApoyo',(isset($actaGrupoApoyo) ? $actaGrupoApoyo->fechaActaGrupoApoyo : $mytime->toDateTimeString()), ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Reuni&oacute;', 'style'=>'width:340;'])!!}
		            </div>
		          </div>
		        </div>

		        <div class="form-group" id='test'>
		          {!!Form::label('horaInicioActaGrupoApoyo', 'Fecha Inicio', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
		              {!!Form::text('horaInicioActaGrupoApoyo',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la hora de Inicio', 'style'=>'width:340;'])!!}
		            </div>
		          </div>
		        </div>

		        <div class="form-group" id='test'>
		          {!!Form::label('horaFinActaGrupoApoyo', 'Fecha Fin', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
		              {!!Form::text('horaFinActaGrupoApoyo',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la hora de Fin', 'style'=>'width:340;'])!!}
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
		                                        <a data-toggle="collapse" data-parent="#accordion" href="#participante">Participantes</a>
		                                    </h4>
		                                </div>
		                                <div id="participante" class="panel-collapse collapse in">
		                                    <div class="panel-body">
		                                        <div class="form-group" id='test'>
		                                            <div class="col-sm-12">
		                                                <div class="row show-grid">
		                                                    <div class="col-md-1" style="width: 40px;height: 60px;" onclick="participante.agregarCampos(valorTercero,'A')">
		                                                        <span class="glyphicon glyphicon-plus"></span>
		                                                    </div>
		                                                    <div class="col-md-1" style="width: 1010px;display:inline-block;height:60px;">Empleados</div>
		                                                    <div id="contenedor_participante">
		                                                    </div>
		                                                </div>
		                                            </div>
		                                        </div>
		                                    </div>
		                                </div>
		                            </div>
		                            
		                            <div class="panel panel-default">
		                                <div class="panel-heading">
		                                    <h4 class="panel-title">
		                                        <a data-toggle="collapse" data-parent="#accordion" href="#tema">Temas Tratados</a>
		                                    </h4>
		                                </div>
		                                <div id="tema" class="panel-collapse collapse">
		                                    <div class="panel-body">
		                                        <div class="form-group" id='test'>
		                                            <div class="col-sm-12">
		                                                <div class="row show-grid">
		                                                    <div class="col-md-1" style="width: 40px;height: 60px;" onclick="tema.agregarCampos(valorTema,'A')">
		                                                        <span class="glyphicon glyphicon-plus"></span>
		                                                    </div>
		                                                    <div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Tema</div>
		                                                    <div class="col-md-1" style="width: 300px;display:inline-block;height:60px;">Desarrollo del Tema</div>
		                                                    <div class="col-md-1" style="width: 200px;display:inline-block;height:60px;">Respoonsable</div>
		                                                    <div class="col-md-1" style="width: 200px;display:inline-block;height:60px;">Observaciones</div>
		                                                    <div id="contenedor_tema">
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
		        </div>
				<div class="form-group" id='test'>
		          {!!Form::label('observacionActaGrupoApoyo', 'Observaciones', array('class' => 'col-sm-2 control-label'))!!}
		          <div class="col-sm-10" >
		            <div class="input-group">
		              <span class="input-group-addon">
		                <i class="fa fa-calendar" ></i>
		              </span>
          		        {!!Form::textarea('observacionActaGrupoApoyo',null,['class'=>'ckeditor','placeholder'=>'Ingresa las observaciones generales de la reunión'])!!}

		            </div>
		          </div>
		        </div>


				</fieldset>	
				@if(isset($actaGrupoApoyo))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary"])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 				@endif
		</div>
	{!!Form::close()!!}	

<script type="text/javascript">
    $('#fechaActaGrupoApoyo').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    $('#horaInicioActaGrupoApoyo').datetimepicker(({
    	format: "HH:mm:ss"
    }));

    $('#horaFinActaGrupoApoyo').datetimepicker(({
	   	format: "HH:mm:ss"
    }));


    CKEDITOR.replace(('observacionActaGrupoApoyo'), {
        fullPage: true,
        allowedContent: true
      });  
</script>

@stop