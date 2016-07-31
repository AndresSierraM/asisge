@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Entrega de Elementos de </br> Protecci&oacute;n Personal</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/elementoproteccion.js')!!}


{!!Html::style('css/signature-pad.css'); !!} 


<?php
  // tomamos la imagen de la firma y la convertimos en base 64 para asignarla
  // al cuadro de imagen y al input oculto de firmabase64
  $base64 = ''; 
  if(isset($entregaelementoproteccion))
  {
    $path = 'imagenes/'.$entregaelementoproteccion["firmaTerceroEntregaElementoProteccion"];
    
    if($entregaelementoproteccion["firmaTerceroEntregaElementoProteccion"] != "" and file_exists($path))
    {
      $type = pathinfo($path, PATHINFO_EXTENSION);
      $data = file_get_contents($path);
      $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    }
  }
?>

<script>

    var idElementoProteccion = '<?php echo isset($idElementoProteccion) ? $idElementoProteccion : "";?>';
    var nombreElementoProteccion = '<?php echo isset($nombreElementoProteccion) ? $nombreElementoProteccion : "";?>';
    var ElementoProteccion = [JSON.parse(idElementoProteccion),JSON.parse(nombreElementoProteccion)];

    var entregaelementoprotecciondetalle = '<?php echo (isset($entregaelementoproteccion) ? json_encode($entregaelementoproteccion->entregaelementoprotecciondetalles) : "");?>';
    entregaelementoprotecciondetalle = (entregaelementoprotecciondetalle != '' ? JSON.parse(entregaelementoprotecciondetalle) : '');
    var valorEntregaElemento = [0,'','',0];

    $(document).ready(function(){

      entregaelementoproteccion = new Atributos('entregaelementoproteccion','contenedor_entregaelementoproteccion','entregaelementoproteccion_');

      entregaelementoproteccion.altura = '36px;';
      entregaelementoproteccion.campoid = 'idEntregaElementoProteccionDetalle';
      entregaelementoproteccion.campoEliminacion = 'eliminarElemento';

      entregaelementoproteccion.campos   = ['idEntregaElementoProteccionDetalle', 'ElementoProteccion_idElementoProteccion', 'descripcionElementoProteccion', 'cantidadEntregaElementoProteccionDetalle'];
      entregaelementoproteccion.etiqueta = ['input', 'select', 'input', 'input'];
      entregaelementoproteccion.tipo     = ['hidden', '', 'text', 'text'];
      entregaelementoproteccion.estilo   = ['', 'width: 200px;height:35px;','width: 500px;height:35px;','width:100px;height:35px;','width:250px;height:35px;'];
      entregaelementoproteccion.clase    = ['', 'chosen-select','',''];
      entregaelementoproteccion.sololectura = [false, false,true,false];

      var eventochange = ['onchange','llenarDescripcion(this.value, this.id);'];
      entregaelementoproteccion.funciones = ['', eventochange,'',''];
      entregaelementoproteccion.opciones = ['',ElementoProteccion,'',''];
      


      for(var j=0, k = entregaelementoprotecciondetalle.length; j < k; j++)
      {
        entregaelementoproteccion.agregarCampos(JSON.stringify(entregaelementoprotecciondetalle[j]),'L');
        llenarDescripcion(document.getElementById('ElementoProteccion_idElementoProteccion'+j).value, document.getElementById('ElementoProteccion_idElementoProteccion'+j).id);
      }

      //En el momento de editar
      //Consulta si el campo Tercero_idTercero esta lleno (>0) y si es así le envía a campo cargo su valor
      if(document.getElementById('Tercero_idTercero').value > 0)
      {
        llenarCargo(document.getElementById('Tercero_idTercero').value); //llama al metodo llenarCargo y llena el campo cargo
      }

    });

    
  </script>


	@if(isset($entregaelementoproteccion))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($entregaelementoproteccion,['route'=>['entregaelementoproteccion.destroy',$entregaelementoproteccion->idEntregaElementoProteccion],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($entregaelementoproteccion,['route'=>['entregaelementoproteccion.update',$entregaelementoproteccion->idEntregaElementoProteccion],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'entregaelementoproteccion.store','method'=>'POST'])!!}
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
<div id='form-section' >

	<fieldset id="entregaelementoproteccion-form-fieldset">

        <div class="form-group" id='test'>
              {!!Form::label('Tercero_idTercero', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}          
              <div class="col-sm-10">
                  <div class="input-group">
                      <span class="input-group-addon">
                        <i class="fa fa-flag"></i>
                      </span>
              {!!Form::select('Tercero_idTercero',$tercero, (isset($entregaelementoproteccion) ? $entregaelementoproteccion->Tercero_idTercero : 0),["class" => "chosen-select form-control",'onchange'=>'llenarCargo(this.value)', "placeholder" =>"Seleccione el empleado"])!!}

              <div class="col-sm-10">
                <img id="firma" style="width:200px; height: 150px; border: 1px solid;" onclick="mostrarFirma();" src="<?php echo $base64;?>">
                {!!Form::hidden('firmabase64', $base64, array('id' => 'firmabase64'))!!}
                {!!Form::hidden('idEntregaElementoProteccion', null, array('id' => 'idEntregaElementoProteccion'))!!}
              </div>
            </div>
          </div>
          
        </div>
        <input type="hidden" id="token" value="{{csrf_token()}}"/>

		
		<div class="form-group" id='test'>
          {!!Form::label('nombreCargo', 'Cargo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
      				{!!Form::text('nombreCargo',null,['class'=>'form-control', 'id'=>'nombreCargo', 'readonly','placeholder'=>''])!!}
              {!!Form::hidden('eliminarElemento', '', array('id' => 'eliminarElemento'))!!}
            </div>
          </div>

          
          <div class="form-group" id='test'>
          {!! Form::label('fechaEntregaElementoProteccion', 'Fecha de Entrega', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {!!Form::text('fechaEntregaElementoProteccion',null,['class'=>'form-control','placeholder'=>'Selecciona la fecha de entrega'])!!}
            </div>
          </div>
        </div>
        <!-- Calendario para el campo fecha de entrega -->
        <script type="text/javascript">
          $('#fechaEntregaElementoProteccion').datetimepicker(({
           format: "YYYY-MM-DD"
          }));
        </script>
          </br>
          </br>
          </br>
          </br>
          </br>
        <h4 id="titulo"><center></center></h4>
        <div class="panel-body">
          <div class="form-group" id='test'>
            <div class="col-sm-12">
              <div class="row show-grid">
                <div class="col-md-1" style="width: 40px;" onclick="entregaelementoproteccion.agregarCampos(valorEntregaElemento,'A')">
                  <span class="glyphicon glyphicon-plus"></span>
                </div>
                <div class="col-md-1" style="width: 200px;">Elemento</div>
                <div class="col-md-1" style="width: 500px;">Descripci&oacute;n</div>
                <div class="col-md-1" style="width: 100px;">Cantidad</div>
                <div id="contenedor_entregaelementoproteccion">
                </div>
              </div>
            </div>
          </div>
        </div>

    </fieldset>
    
	@if(isset($entregaelementoproteccion))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary","onclick"=>'validarFormulario(event);'])!!}
 	@endif

	{!! Form::close() !!}
	</div>
</div>

<script type="text/javascript">

  $(document).ready(function()
  {
    mostrarFirma();
  });
    

</script>
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app.js'); !!}

@stop