@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Acta de Reunión<br>Grupo de Apoyo</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/actagrupoapoyo.js')!!}
{!!Html::style('css/signature-pad.css'); !!} 


<?php

$firmas = isset($actaGrupoApoyo->actaGrupoApoyoTercero) ? $actaGrupoApoyo->actaGrupoApoyoTercero : null;

for ($i=0; $i < count($firmas); $i++) 
{ 

  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  
  // al array de la consulta, le adicionamos 2 valores mas que representan la firma como imagen y como dato base 64, este array lo usamos para llenar el detalle de terceros participantes

  $firmas[$i]["firma"] = ''; 
  $firmas[$i]["firmabase64"] = ''; 
  if(isset($firmas))
  {
    $path = 'imagenes/'.$firmas[$i]["firmaActaGrupoApoyoTercero"];
  
    if($firmas[$i]["firmaActaGrupoApoyoTercero"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $firmas[$i]["firma"] = 'data:image/' . $type . ';base64,' . base64_encode($data);
      $firmas[$i]["firmabase64"] = 'data:image/' . $type . ';base64,' . base64_encode($data);
      
    }
  }

}

?>


	<script>
		var actaGrupoApoyoTema = '<?php echo (isset($actaGrupoApoyo) ? json_encode($actaGrupoApoyo->actaGrupoApoyoTema) : "");?>';
		actaGrupoApoyoTema = (actaGrupoApoyoTema != '' ? JSON.parse(actaGrupoApoyoTema) : '');

		// usamos el array de participantes que llenamos al principio de esta vista en un segmento de PHP
		var actaGrupoApoyoTercero = '<?php echo (isset($firmas) ? json_encode($firmas) : "");?>';
		actaGrupoApoyoTercero = (actaGrupoApoyoTercero != '' ? JSON.parse(actaGrupoApoyoTercero) : '');

		var valorTercero = [0,0,'',''];
		var valorTema = [0,'','',0,''];

		var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
		var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';

		var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

		$(document).ready(function(){


			participante = new Atributos('participante','contenedor_participante','participante_');

			participante.altura = '65px;';
			participante.campoid = 'idActaGrupoApoyoTercero';
			participante.campoEliminacion = 'eliminarTercero';

			participante.campos = ['idActaGrupoApoyoTercero', 'Tercero_idParticipante','firma','firmabase64'];
			participante.etiqueta = ['input','select','firma','input'];
			participante.tipo = ['hidden','','','hidden'];
			participante.estilo = ['','width: 700px;height:60px;', 'width:100px; height: 60px; border: 1px solid; display: inline-block', ''];
			participante.clase = ['','','',''];
			participante.sololectura = [false,false,false,false];
			participante.completar = ['off','off','off','off'];
			participante.opciones = ['',tercero,'',''];
			participante.funciones  = ['','', '' ,''];

				
			tema = new Atributos('tema','contenedor_tema','tema_');

			tema.altura = '36px;';
			tema.campoid = 'idActaGrupoApoyoTema';
			tema.campoEliminacion = 'eliminarTema';

			tema.campos = ['idActaGrupoApoyoTema', 'temaActaGrupoApoyoTema', 'desarrolloActaGrupoApoyoTema','Tercero_idResponsable','observacionActaGrupoApoyoTema'];
			tema.etiqueta = ['input', 'input','input','select','input'];
			tema.tipo = ['hidden','','','',''];
			tema.estilo = ['','width: 250px;height:35px;','width: 250px;height:35px;','width: 150px;height:35px;','width: 200px;height:35px;'];
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


	<script>
    var idTercero = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTercero = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
    var tercero = [JSON.parse(idTercero),JSON.parse(nombreCompletoTercero)];

    var idDocumento = '<?php echo isset($idDocumento) ? $idDocumento : "";?>';
    var nombreDocumento = '<?php echo isset($nombreDocumento) ? $nombreDocumento : "";?>';
    var documento = [JSON.parse(idDocumento),JSON.parse(nombreDocumento)];

    var actaGrupoApoyoDetalle = '<?php echo (isset($actaGrupoApoyo) ? json_encode($actaGrupoApoyo->actaGrupoApoyoDetalle) : "");?>';
    console.log(actaGrupoApoyoDetalle);
    actaGrupoApoyoDetalle = (actaGrupoApoyoDetalle != '' ? JSON.parse(actaGrupoApoyoDetalle) : '');
    var valorActaGrupoApoyo = ['',0,0,'',0,'',0,''];

    $(document).ready(function(){


      actagrupoapoyo = new Atributos('actagrupoapoyo','contenedor_actagrupoapoyo','actagrupoapoyo_');

      actagrupoapoyo.altura = '36px;';
	  actagrupoapoyo.campoid = 'idActaGrupoApoyoDetalle';
	  actagrupoapoyo.campoEliminacion = 'eliminarActividad';


      actagrupoapoyo.campos    = ['actividadGrupoApoyoDetalle', 'Tercero_idResponsableDetalle', 'Documento_idDocumento',
                            'fechaPlaneadaActaGrupoApoyoDetalle', 'recursoPlaneadoActaGrupoApoyoDetalle', 
                            'fechaEjecucionGrupoApoyoDetalle','recursoEjecutadoActaGrupoApoyoDetalle', 
                             'observacionGrupoApoyoDetalle'];
      actagrupoapoyo.etiqueta  = ['input', 'select','select',  
                            'input', 'input',
                            'input', 'input', 
                            'input'];
      actagrupoapoyo.tipo      = ['text', '', '',
                            'date', 'number', 
                            'date', 'number', 
                            'text'];
      actagrupoapoyo.estilo    = ['width: 400px; height:35px; ', 
                            'width: 200px; height:35px; ', 
                            'width: 200px; height:35px; ', 
                            'width: 200px; height:35px; ', 
                            'width: 100px; height:35px; text-align: right;', 
                            'width: 200px; height:35px; ', 
                            'width: 100px; height:35px; text-align: right;', 
                            'width: 300px; height:35px; '];
      actagrupoapoyo.clase     = ['', 'chosen-select', 'chosen-select', 
                            '', '',
                            '', '',
                            ''];
      actagrupoapoyo.sololectura = [false,false,false,false,false,false,false,false];
      actagrupoapoyo.completar = ['off', 'off','off','off','off','off','off','off'];
      actagrupoapoyo.opciones = ['', tercero, documento,'','','','',''];
      actagrupoapoyo.funciones  = ['', '','','','','','',''];



      actagrupoapoyo.nombreCompletoTercero =  JSON.parse(nombreCompletoTercero);
      actagrupoapoyo.idTercero =  JSON.parse(idTercero);
      actagrupoapoyo.nombreDocumento =  JSON.parse(nombreDocumento);
      actagrupoapoyo.idDocumento =  JSON.parse(idDocumento);

      for(var j=0, k = actaGrupoApoyoDetalle.length; j < k; j++)
      {
        actagrupoapoyo.agregarCampos(JSON.stringify(actaGrupoApoyoDetalle[j]),'L');
      }
      document.getElementById('registros').value = j ;
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

	<div id="signature-pad" class="m-signature-pad">
		<input type="hidden" id="signature-reg" value="">
	    <div class="m-signature-pad--body">
	      <canvas></canvas>
	    </div>
	    <div class="m-signature-pad--footer">
	      <div class="description">Firme sobre el recuadro</div>
	      <button type="button" class="button clear btn btn-danger" data-action="clear">Limpiar</button>
	      <button type="button" class="button save btn btn-success" data-action="save">Guardar Firma</button>
	    </div>
	</div>

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

							{!!Form::hidden('idActaGrupoApoyo', null, array('id' => 'idActaGrupoApoyo'))!!}
							{!!Form::hidden('eliminarTema', '', array('id' => 'eliminarTema'))!!}
					      	{!!Form::hidden('eliminarTercero', '', array('id' => 'eliminarTercero'))!!}
					      	{!!Form::hidden('eliminarActividad', '', array('id' => 'eliminarActividad'))!!}
					      	{!! Form::hidden('registros', 0, array('id' => 'registros')) !!}
						</div>
					</div>
				</div>

		        <div class="form-group" id='test'>
		          {!!Form::label('fechaActaGrupoApoyo', 'Fecha Reuni&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
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
		          {!!Form::label('horaInicioActaGrupoApoyo', 'Hora Inicio', array('class' => 'col-sm-2 control-label'))!!}
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
		          {!!Form::label('horaFinActaGrupoApoyo', 'Hora Fin', array('class' => 'col-sm-2 control-label'))!!}
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
		                                                    <div class="col-md-1" style="width: 700px;display:inline-block;height:60px;">Empleados</div>
		                                                    <div class="col-md-1" style="width: 100px;display:inline-block;height:60px;">Firma</div>
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
		                                                    <div class="col-md-1" style="width: 250px;display:inline-block;height:60px;">Tema</div>
		                                                    <div class="col-md-1" style="width: 250px;display:inline-block;height:60px;">Desarrollo del Tema</div>
		                                                    <div class="col-md-1" style="width: 150px;display:inline-block;height:60px;">Responsable</div>
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
		                    
		                    <div class="col-md-1" style="width: 40px;" onclick="actagrupoapoyo.agregarCampos(valorActaGrupoApoyo,'A')">
		                      <span class="glyphicon glyphicon-plus"></span>
		                    </div>
		                      
		                    <div class="col-md-1" style="width: 400px;">Actividad</div>
		                    <div class="col-md-2" style="width: 200px;">Responsable</div>
		                    <div class="col-md-3" style="width: 200px;">Documento</div>
		                    <div class="col-md-4" style="width: 200px;">Fecha</div>
		                    <div class="col-md-5" style="width: 100px;">Recurso $</div>
		                    <div class="col-md-6" style="width: 200px;">Fecha</div>
		                    <div class="col-md-7" style="width: 100px;">Recurso $</div>
		                    <div class="col-md-8" style="width: 300px;">Observaci&oacute;n</div>
		                    <div id="contenedor_actagrupoapoyo">
		                    </div>
		                  </div>
		                </div>
		              </div>
		            </div>
		          </div>
		        </div>

		        <input type="hidden" id="token" value="{{csrf_token()}}"/>

				</fieldset>	
				@if(isset($actaGrupoApoyo))
					{!!Form::submit(((isset($_GET['accion']) and $_GET['accion'] == 'eliminar') ? 'Eliminar' : 'Modificar'),["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
				@else
  					{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
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



  $(document).ready(function()
  {
    mostrarFirma();
  });
    

</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}



@stop