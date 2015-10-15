@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Diagn&oacute;stico General</center></h3>@stop
@section('content')
@include('alerts.request')


{!!Html::script('js/diagnostico.js')!!}
  <script>

    var diagnosticoDetalle = '<?php echo (isset($preguntas) ? json_encode($preguntas) : "");?>';

    diagnosticoDetalle = (diagnosticoDetalle != '' ? JSON.parse(diagnosticoDetalle) : '');
    var valorPermisos = [0,'','',0,0,0,0];

    $(document).ready(function(){

        // creamos los titulos del detalle por cada grupo de preguntas
        titulos = new Titulos('Titdiagnostico','Titcontenedor_diagnostico','Titdiagnostico_');
        titulos.texto   = ['Pregunta', 'Puntuacion', 'Resultado','Acción de Mejora'];
        titulos.estilo   = ['width: 500px;', 'width: 100px;',     'width: 100px;',  'width: 420px;'];
        titulos.clase   = ['col-md-1','col-md-1','col-md-1','col-md-1'];

        // creamos los campos del detalle por cada pregunta, en los cuales solo se llenan 3 campos
        // puntuacion (digitado por el susuario de 1 a 5 )
        // resultado, calculado por el sistema (resultado = puntuacion * 20  expresado como porcentaje)
        // mejora (digitado por le usuario, editor de texto libre)
        diagnostico = new Atributos('diagnostico','Titcontenedor_diagnostico','diagnostico_');
        diagnostico.campos   = ['DiagnosticoPregunta_idDiagnosticoPregunta',  'detalleDiagnosticoPregunta', 'puntuacionDiagnosticoDetalle',   'resultadoDiagnosticoDetalle','mejoraDiagnosticoDetalle'];
        diagnostico.etiqueta = ['input',                                      'textarea',                   'input',                          'input',                      'textarea'];
        diagnostico.tipo     = ['hidden',                                     'textarea',                   'text',                           'text',                       'textarea'];
        diagnostico.estilo   = ['',                                           
                                'vertical-align:top; resize:none; font-size:10px; width: 500px; height:60px;', 
                                'vertical-align:top; text-align: center; width: 100px;  height:60px;',
                                'vertical-align:top; text-align: center; width: 100px;  height:60px;',
                                'vertical-align:top; resize:none; font-size:10px; width: 420px; height:60px;'];
        diagnostico.clase    = ['','','','',''];
        diagnostico.sololectura = [false,true,false,true,false];
        diagnostico.calculo = [false,false,true,false,false];

        // hacemos un rompimiento de control para agrupar las preguntas
        grupo = '';
        for(var j=0, k = diagnosticoDetalle.length; j < k; j++)
        {
          // cada que cambie el grupo de preguntas, ponemos titulos
          if(grupo != diagnosticoDetalle[j]["nombreDiagnosticoGrupo"])
          {
            grupo = diagnosticoDetalle[j]["nombreDiagnosticoGrupo"];

            // llena los titulos de preguntas
            titulos.agregarTitulos(diagnosticoDetalle[j]["idDiagnosticoGrupo"], grupo);
          }
          // llena los campos de preguntas
          diagnostico.agregarCampos(JSON.stringify(diagnosticoDetalle[j]),'L', diagnosticoDetalle[j]["idDiagnosticoGrupo"]);
        }

    });

    function calcularResultado()
    {
      var cambio = "document.getElementById('"+this.id.replace('puntuacionDiagnosticoDetalle','resultadoDiagnosticoDetalle') + "').value = "+this.value+" * 20;";
      eval(cambio);
    }

  </script>

	@if(isset($diagnostico))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($diagnostico,['route'=>['diagnostico.destroy',$diagnostico->idDiagnostico],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($diagnostico,['route'=>['diagnostico.update',$diagnostico->idDiagnostico],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'diagnostico.store','method'=>'POST', 'files' => true])!!}
	@endif


<div id='form-section' >

	<fieldset id="diagnostico-form-fieldset">	
		    <div class="form-group" id='test'>
          {!! Form::label('codigoDiagnostico', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoDiagnostico',null,['class'=>'form-control','placeholder'=>'Ingresa el codigo del diagnostico'])!!}
              {!! Form::hidden('idDiagnostico', null, array('id' => 'idDiagnostico')) !!}
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaElaboracionDiagnostico', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaElaboracionDiagnostico',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
            </div>
          </div>
        </div>
		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreDiagnostico', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombreDiagnostico',null,['class'=>'form-control','placeholder'=>'Ingresa la descripci&oacute;n del diagnostico'])!!}
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
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Equipos Cr&iacute;ticos</a>
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
                                {!!Form::textarea('equiposCriticosDiagnostico',null,['class'=>'form-control','placeholder'=>'Especfica los objetos criticos'])!!}
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>


                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Herramientas  Cr&iacute;ticas</a>
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
                                  {!!Form::textarea('herramientasCriticasDiagnostico',null,['class'=>'form-control','placeholder'=>'Especfica las herramientas criticas'])!!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title">
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Observaciones</a>
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
                                {!!Form::textarea('observacionesDiagnostico',null,['class'=>'form-control','placeholder'=>'Especfica las observaciones del diagnostico'])!!}
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


        <table class="table table-striped table-bordered" width="100%">
          <tr>
                <th colspan="1">La calificación posible es entre 1 y 5, segun el grado de cumplimiento del aspecto evaluado</th>
                <th colspan="3">% cumplimiento</th>
              </tr>
              <tr>
                <td colspan="1">1 = No se cumple con el aspecto evaluado</td>
                <td colspan="1" style="background-color:red;">&nbsp;</td>
                <td colspan="2">entre 0% y 35%</td>
              </tr>
              <tr>
                <td colspan="1">3 = Se cumple parcialmente con el aspecto evaluado</td>
                <td colspan="1" style="background-color:yellow;">&nbsp;</td>
                <td colspan="2">entre 36% y 70%</td>
              </tr>
              <tr>
                <td colspan="1">5 = Se cumple totalmente con el aspecto evaluado</td>
                <td colspan="1" style="background-color:green;">&nbsp;</td>
                <td colspan="2">entre 71% y 100%</td>
              </tr>
        </table>


        <div class="panel-body">
          <div class="form-group" id='test'>
            <div id="detalle" class="col-sm-12">
        
            </div>
          </div>
        </div>
    </fieldset>
	@if(isset($diagnostico))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"validarFormulario(event);"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
 	@endif
	{!! Form::close() !!}

  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
        $('#fechaElaboracionDiagnostico').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

  </script>


	</div>
</div>
@stop