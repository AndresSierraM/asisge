@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Tipo de Tarea</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/tipotarea.js')!!}
<!-- Librerías para el selector de colores (color Picker) -->
{!! Html::style('assets/colorpicker/css/bootstrap-colorpicker.min.css'); !!}
{!! Html::script('assets/colorpicker/js/bootstrap-colorpicker.js'); !!}

<?php
$datos =  isset($tipotarea) ? $tipotarea->dependenciaPermiso : array();


for($i = 0; $i < count($datos); $i++)
{
  $ids = explode(',', $datos[$i]["Rol_idRol"]);

   $nombres = DB::table('rol')
             ->select(DB::raw('group_concat(nombreRol) AS nombreRol'))
            ->whereIn('idRol',$ids)
            ->get();
  $vble = get_object_vars($nombres[0] );
  $datos[$i]["nombreRolPermiso"] = $vble["nombreRol"];
}
?>

<script>
    var idRol = '<?php echo isset($idRol) ? $idRol : "";?>';
    var nombreRol = '<?php echo isset($nombreRol) ? $nombreRol : "";?>';

    var dependenciapermisos = '<?php echo (isset($tipotarea) ? json_encode($tipotarea->dependenciaPermiso) : "");?>';
    dependenciapermisos = (dependenciapermisos != '' ? JSON.parse(dependenciapermisos) : '');
    var valorTipoTarea = ['','', 0];

    $(document).ready(function(){

      permisos = new Atributos('permisos','contenedor_permisos','permisos_');

      permisos.altura = '35px';
      permisos.campoid = 'idTipoTareaPermiso';
      permisos.campoEliminacion = 'eliminarTipoTareaPermiso';

      permisos.campos   = ['Rol_idRol', 'nombreRolPermiso', 'idTipoTareaPermiso'];
      permisos.etiqueta = ['input', 'input', 'input'];
      permisos.tipo     = ['hidden', 'text', 'hidden'];
      permisos.estilo   = ['', 'width: 900px;height:35px;' ,''];
      permisos.clase    = ['','', '', ''];
      permisos.sololectura = [true,true,true];
      for(var j=0, k = dependenciapermisos.length; j < k; j++)
      {
        permisos.agregarCampos(JSON.stringify(dependenciapermisos[j]),'L');
        console.log(JSON.stringify(dependenciapermisos[j]))
      }

    });

  </script>


	 @if(isset($tipotarea))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($tipotarea,['route'=>['tipotarea.destroy',$tipotarea->idTipoTarea],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($tipotarea,['route'=>['tipotarea.update',$tipotarea->idTipoTarea],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'tipotarea.store','method'=>'POST'])!!}
  @endif


<div id='form-section'>

  <fieldset id="tipotarea-form-fieldset"> 
      	<div class="form-group" id='test'>
	        {!!Form::label('codigoTipoTarea', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
	      <div class="col-sm-10">
	        <div class="input-group">
	            <span class="input-group-addon">
	              <i class="fa fa-barcode"></i>
	            </span>
	            {!!Form::text('codigoTipoTarea',null,['class'=>'form-control','placeholder'=>'Ingresa el código del tipo de tarea'])!!}
	          {!!Form::hidden('idTipoTarea', null, array('id' => 'idTipoTarea')) !!}
	          {!!Form::hidden('eliminarTipoTarea', null, array('id' => 'eliminarTipoTarea')) !!}
	        </div>
	      </div>
	    </div>


    
      	<div class="form-group" id='test'>
          {!!Form::label('nombreTipoTarea', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
        	  {!!Form::text('nombreTipoTarea',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del tipo de tarea'])!!}
            </div>
          </div>
      	</div>



      	<div class="form-group" id='test'>
	      {!!Form::label('colorTipoTarea', 'Color', array('class' => 'col-sm-2 control-label')) !!}
	      <div class="col-sm-10">
	        <div class="input-group">
	          <span class="input-group-addon">
	              <i class="fa fa-sliders"></i>
	          </span>
	      	  <div id="colorTipoTarea" class="input-group colorpicker-component" style="width: 100%;">
			  <input id="colorFondoTipoTarea" type="hidden" value="#255986" class="form-control"/>
			  <span class="input-group-addon"><i style="width: 100%;"></i></span>
			</div>
	      	  <script>
				  $(function () {
				      $('#colorTipoTarea').colorpicker();
				  });
			</script>
	        </div>
	      </div>
      	</div>  

      <br><br><br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Contenido</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#permisoTipoTarea">Contenido</a>
                      </h4>
                    </div>
                    <div id="permisoTipoTarea" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                              <div class="col-md-1" style="width: 40px; cursor: pointer;" onclick="abrirModalRol();">
                                <span class="glyphicon glyphicon-plus"></span>
                              </div>
                              <div class="col-md-1" style="width: 900px;">Rol</div>
                              <div id="contenedor_permisos"> 
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
    </fieldset>

<div id="myModalRol" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:100%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Roles</h4>
      </div>
      <div class="modal-body">
      <iframe style="width:100%; height:500px; " id="rol" name="rol" src="{!! URL::to ('rolselect')!!}"> </iframe> 
      </div>
    </div>
  </div>
</div>

	@if(isset($tipotarea))
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
@stop