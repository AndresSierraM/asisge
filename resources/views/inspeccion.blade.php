@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Inspecci&oacute;n de Seguridad</center></h3>@stop
@section('content')
@include('alerts.request')

{!!Html::script('js/inspeccion.js')!!} 

{!!Html::style('css/signature-pad.css'); !!} 
{!!Html::style('css/image-pad.css'); !!} 


<?php
  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  $base64 = ''; 
  if(isset($inspeccion))
  {
    $path = 'imagenes/'.$inspeccion["firmaRealizadaPorInspeccion"];
    
    if($inspeccion["firmaRealizadaPorInspeccion"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
  }
?>



  <script>

  function CargarPreguntas(id)
  {

    var token = document.getElementById('token').value;

    $.ajax({
      async: true,
      headers: {'X-CSRF-TOKEN': token},
      url: 'http://'+location.host+'/inspeccion/'+id,
      type: 'POST',
      dataType: 'JSON',
      method: 'GET',
      data: {idTipoInspeccion: id},
      success: function(data){
       
        if (data) {
            var data = $.map(data, function(el) { return el });
            // hacemos un rompimiento de control para agrupar las preguntas
            document.getElementById('registros').value = 0;

            // primero eliminamos los registros actuales, para que no se combinen preguntas de inspecciones diferentes planes cuando el usuario cambie de tipo de inspeccion
            inspeccion.borrarTodosCampos();

            for(var j=0, k = data.length; j < k; j++)
            {
              var dataIns = $.map(data[j], function(el) { return el });
              // llena los campos de preguntas

              var valorInspeccion = [0, dataIns[0],dataIns[01],dataIns[2],'','','','','','',0,'',''];
              inspeccion.agregarCampos(valorInspeccion,'A');
            }
            document.getElementById('registros').value = j ;

        } 
        else 
        {
               alert('<div> No hay preguntas asociadas al tipo de inspeccion. </div>');
        }
      }
    });

    

  }

    var idTerceroResponsable = '<?php echo isset($idTercero) ? $idTercero : "";?>';
    var nombreCompletoTerceroResponsable = '<?php echo isset($nombreCompletoTercero) ? $nombreCompletoTercero : "";?>';
    var terceroResponsable = [JSON.parse(idTerceroResponsable),JSON.parse(nombreCompletoTerceroResponsable)];

    //var onclick = ['onclick','visualizarArchivoInspeccion(this.value)']

     var inspeccionDetalle = '<?php echo (isset($preguntas) ? json_encode($preguntas) : "");?>';
    // var inspeccionDetalle = '<?php echo (isset($inspeccion) ? json_encode($inspeccion->inspeccionDetalle) : "");?>';

    inspeccionDetalle = (inspeccionDetalle != '' ? JSON.parse(inspeccionDetalle) : '');
    var valorInspeccion = [0,0,'','','','','','','',0,'',''];

    $(document).ready(function(){


        // creamos los campos del detalle por cada pregunta, en los cuales solo se llenan 3 campos
        // puntuacion (digitado por el susuario de 1 a 5 )
        // resultado, calculado por el sistema (resultado = puntuacion * 20  expresado como porcentaje)
        // mejora (digitado por le usuario, editor de texto libre)
        inspeccion = new Atributos('detalle','contenedor_detalle','detalle_');

        // como este formulario no lleva caneca para eliminar registros de detalle, no llenamos las
        // propiedades correspondientes
        inspeccion.altura = '62px;';
        inspeccion.campoid = '';
        inspeccion.campoEliminacion = '';
        inspeccion.botonEliminacion = false;

        inspeccion.campos   = ['idInspeccionDetalle', 'TipoInspeccionPregunta_idTipoInspeccionPregunta',  'numeroTipoInspeccionPregunta', 'contenidoTipoInspeccionPregunta',  'situacionInspeccionDetalle',   'archivoInspeccionDetalle','fotoInspeccionDetalle','ubicacionInspeccionDetalle', 'accionMejoraInspeccionDetalle','Tercero_idResponsable','fechaInspeccionDetalle',
                              'observacionInspeccionDetalle'];
        inspeccion.etiqueta = ['input', 'input', 'input', 'textarea',
                               'textarea', 'file', 'imagen', 'textarea',
                               'textarea', 'select', 'input',
                               'textarea'];
        inspeccion.tipo     = ['hidden','hidden', 'text', 'textarea', 
                               'textarea', '', 'imagen', 'textarea',
                               'textarea', '', 'date',
                               'textarea'];
        inspeccion.estilo   = ['','',
                                'vertical-align:top; resize:none; width: 60px; height:60px;', 
                                'vertical-align:top; resize:none; font-size:10px; width: 300px; height:60px;', 
                                'vertical-align:top; width: 300px;  height:60px;',
                                'vertical-align:top; width: 200px;  height:60px; display: inline-block;',
                                'vertical-align:top; width: 60px;  height:60px; display: inline-block;',
                                'vertical-align:top; resize:none; width: 100px; height:60px;',
                                'vertical-align:top; resize:none; width: 200px; height:60px;',
                                'vertical-align:top; resize:none; width: 200px; height:60px;',
                                'vertical-align:top; resize:none; width: 150px; height:60px;',
                                'vertical-align:top; resize:none; width: 300px; height:60px;'];
        inspeccion.clase    = ['','','','','','','btn btn-primary','','','','',''];
        inspeccion.sololectura = [false,false,true,true, false,false,false,false,false,false,false,false];
      
        inspeccion.opciones = ['','','','','','','','','',terceroResponsable,'',''];

        inspeccion.funciones = ['','','','','','','','','','','',''];

        document.getElementById('registros').value = 0 ;
        // hacemos un rompimiento de control para agrupar las preguntas
        for(var j=0, k = inspeccionDetalle.length; j < k; j++)
        {
          // llena los campos de preguntas
          inspeccion.agregarCampos(JSON.stringify(inspeccionDetalle[j]),'L', inspeccionDetalle[j]["idInspeccionGrupo"]);
          cargarArchivoInspeccion($('#fotoInspeccionDetalle'+j).attr('id'), $('#idInspeccionDetalle'+j).val());
          // console.log(inspeccionDetalle[j]);
        }
        document.getElementById('registros').value = j ;
    });

  </script>

	@if(isset($inspeccion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($inspeccion,['route'=>['inspeccion.destroy',$inspeccion->idInspeccion],'method'=>'DELETE', 'files' => true])!!}
		@else
			{!!Form::model($inspeccion,['route'=>['inspeccion.update',$inspeccion->idInspeccion],'method'=>'PUT', 'files' => true])!!}
		@endif
	@else
		{!!Form::open(['route'=>'inspeccion.store','method'=>'POST', 'files' => true])!!}
	@endif

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


<div id="image-pad" class="m-image-pad">
    <input type="hidden" id="image-reg" value="">
      <div class="m-image-pad--body">
        <img id="image-src"></img>
      </div>
      <div class="m-image-pad--footer">
        <div class="description">Vista previa de la imagen</div>
        <button type="button" class="button clear btn btn-primary" data-action="close">Cerrar</button>
      </div>
  </div>


<div id='form-section' >

	<fieldset id="inspeccion-form-fieldset">	

        <div class="form-group" id='test'>
          {!!Form::label('TipoInspeccion_idTipoInspeccion', 'Tipo de Inspecci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-flag"></i>
              </span>
              <input type="hidden" id="token" value="{{csrf_token()}}"/>
              {!!Form::select('TipoInspeccion_idTipoInspeccion',$tipoinspeccion, (isset($inspeccion) ? $inspeccion->TipoInspeccion_idTipoInspeccion : 0),["onchange" => "CargarPreguntas(this.value)", "class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de inspecci&oacute;n"])!!}
              
              {!! Form::hidden('idInspeccion', null, array('id' => 'idInspeccion')) !!}
              {!! Form::hidden('registros', 0, array('id' => 'registros')) !!}
            </div>
          </div>
        </div>

          <div class="form-group" id='test'>
              {!!Form::label('Tercero_idRealizadaPor', 'Realizada Por', array('class' => 'col-sm-2 control-label'))!!}       
              <div class="col-sm-10">
                  <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-flag"></i>
                      </span>
              {!!Form::select('Tercero_idRealizadaPor',$tercero, (isset($inspeccion) ? $inspeccion->Tercero_idRealizadaPor : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tercero de quien realiza la inspecci&oacute;n"])!!}

              <div class="col-sm-10">
                <img id="firma" style="width:200px; height: 150px; border: 1px solid;" onclick="mostrarFirma();" src="<?php echo $base64;?>">
                {!!Form::hidden('firmabase64', $base64, array('id' => 'firmabase64'))!!}
              </div>
            </div>
          </div>

        

        <div class="form-group" id='test'>
          {!!Form::label('fechaElaboracionInspeccion', 'Fecha Elaboraci&oacute;n', array('class' => 'col-sm-2 control-label'))!!}
          <div class="col-sm-10" >
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar" ></i>
              </span>
              {!!Form::text('fechaElaboracionInspeccion',null, ['class'=>'form-control', 'placeholder'=>'Ingresa la fecha de Elaboracion', 'style'=>'width:340;'])!!}
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
                          <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Observaciones</a>
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
                                {!!Form::textarea('observacionesInspeccion',null,['class'=>'form-control','placeholder'=>'Especfica observaciones de la inspecci&oacute;n'])!!}
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
                <div style="overflow: auto; width: 100%;">
                  <div style="width: 1910px; height: 300px; display: inline-block; ">
                    <div class="col-md-1" style="width: 1220px;">&nbsp;</div>
                    <div class="col-md-1" style="width: 650px;">Implementaci&oacute;n de la Medida de Intervenci&oacute;n Recomendada</div>
                          
                    <div class="col-md-1" style="width: 60px;">No.</div>
                    <div class="col-md-2" style="width: 300px;">Pregunta</div>
                    <div class="col-md-3" style="width: 300px;">Situaci&oacute;n Identificada</div>
                    <div class="col-md-4" style="width: 260px;">Evidencia Fotogr&aacute;fica</div>
                    <div class="col-md-5" style="width: 100px;">Ubicaci&oacute;n</div>
                    <div class="col-md-6" style="width: 200px;">Acci&oacute;n de Mejora</div>
                    <div class="col-md-7" style="width: 200px;">Responsable</div>
                    <div class="col-md-8" style="width: 150px;">Fecha</div>
                    <div class="col-md-8" style="width: 300px;">Observaciones</div>
                    
                    <div id="contenedor_detalle">
                    </div>

                  </div>
                </div>
              </div>
            </div>


            
          </div>
        </div>
    </fieldset>
	@if(isset($inspeccion))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
         {!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
      @else
         {!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>"habilitarSubmit(event);"])!!}
      @endif
  @else
         {!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'habilitarSubmit(event);'])!!}
  @endif
  
  

	{!! Form::close() !!}

  </div>
</div>


  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1250px';
    document.getElementById('contenedor-fin').style.width = '1250px';
    
    $('#fechaElaboracionInspeccion').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

    CKEDITOR.replace(('observacionesInspeccion'), {
        fullPage: true,
        allowedContent: true
      });  

    $(document).ready(function()
    {
      mostrarFirma();
      mostrarImagen();
    });
    

</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}


@stop