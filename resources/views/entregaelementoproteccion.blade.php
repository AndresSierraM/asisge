@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Entrega de Elementos de </br> Protecci&oacute;n Personal</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/elementoproteccion.js')!!}
<script>

    var idElementoProteccion = '<?php echo isset($idElementoProteccion) ? $idElementoProteccion : "";?>';
    var nombreElementoProteccion = '<?php echo isset($nombreElementoProteccion) ? $nombreElementoProteccion : "";?>';
    var ElementoProteccion = [JSON.parse(idElementoProteccion),JSON.parse(nombreElementoProteccion)];

    var entregaelementoprotecciondetalle = '<?php echo (isset($entregaelementoproteccion) ? json_encode($entregaelementoproteccion->entregaelementoprotecciondetalles) : "");?>';
    entregaelementoprotecciondetalle = (entregaelementoprotecciondetalle != '' ? JSON.parse(entregaelementoprotecciondetalle) : '');
    var valorEntregaElemento = ['','',0];

    $(document).ready(function(){

      entregaelementoproteccion = new Atributos('entregaelementoproteccion','contenedor_entregaelementoproteccion','entregaelementoproteccion_');
      entregaelementoproteccion.campos   = ['ElementoProteccion_idElementoProteccion', 'descripcionElementoProteccion', 'cantidadEntregaElementoProteccionDetalle'];
      entregaelementoproteccion.etiqueta = ['select', 'input', 'input'];
      entregaelementoproteccion.tipo     = ['', 'text', 'text'];
      entregaelementoproteccion.estilo   = ['width: 200px;height:35px;','width: 700px;height:35px;','width:150px;height:35px;','width:250px;height:35px;'];
      entregaelementoproteccion.clase    = ['chosen-select','',''];
      entregaelementoproteccion.nombreElementoProteccion =  JSON.parse(nombreElementoProteccion);
      entregaelementoproteccion.idElementoProteccion =  JSON.parse(idElementoProteccion);
      entregaelementoproteccion.sololectura = [false,true,false];
      entregaelementoproteccion.eventochange = ['llenarDescripcion(this.value, this.id)','',''];
      entregaelementoproteccion.opciones = ['ElementoProteccion','',''];

      for(var j=0, k = entregaelementoprotecciondetalle.length; j < k; j++)
      {
        entregaelementoproteccion.agregarCampos(JSON.stringify(entregaelementoprotecciondetalle[j]),'L');
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


<div id='form-section' >

	<fieldset id="entregaelementoproteccion-form-fieldset">

   <div class="form-group" id='test'>
            {!!Form::label('Tercero_idTercero', 'Empleado', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-user"></i>
                        </span>
                {!!Form::select('Tercero_idTercero',$tercero, (isset($entregaelementoproteccion) ? $entregaelementoproteccion->Tercero_idTercero : 0),["class" => "chosen-select form-control",'onchange'=>'llenarCargo(this.value)', "placeholder" =>"Seleccione el empleado"])!!}
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
                <div class="col-md-1" style="width: 700px;">Descripci&oacute;n</div>
                <div class="col-md-1" style="width: 150px;">Cantidad</div>
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
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif

	{!! Form::close() !!}
	</div>
</div>
@stop