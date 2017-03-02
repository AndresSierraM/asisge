@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Categorías de Agenda</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/categoriaagenda.js')!!}
<!-- Librerías para el selector de colores (color Picker) -->
{!! Html::style('assets/colorpicker/css/bootstrap-colorpicker.min.css'); !!}
{!! Html::script('assets/colorpicker/js/bootstrap-colorpicker.js'); !!}


<script>

    var categoriaagendacampo = '<?php echo (isset($categoriaagenda) ? json_encode($categoriaagenda->categoriaagendacampo) : "");?>';
    categoriaagendacampo = (categoriaagendacampo != '' ? JSON.parse(categoriaagendacampo) : '');

    var valorCategoriaAgenda = ['','', 0];

    $(document).ready(function(){

      protCampos = new Atributos('protCampos','contenedor_protCampos','categoriaagendacampo');

      protCampos.altura = '35px';
      protCampos.campoid = 'idCategoriaAgendaCampo';
      protCampos.campoEliminacion = 'eliminarCategoriaAgenda';

      protCampos.campos   = [
      'idCategoriaAgendaCampo',
      'CampoCRM_idCampoCRM',
      'nombreCampoCRM',
      'obligatorioDocumentoCRMCampo',
      'CategoriaAgenda_idCategoriaAgenda'
      ];

      protCampos.etiqueta = [
      'input',
      'input',
      'input',
      'checkbox',
      'input'
      ];

      protCampos.tipo = [
      'hidden',
      'hidden',
      'text',
      'checkbox',
      'hidden'
      ];

      protCampos.estilo = [
      '',
      '',
      'width: 610px;height:35px;',
      'width: 150px;height:35px; display:inline-block;',
      ''
      ];

      protCampos.clase    = ['','','','','','','',''];
      protCampos.sololectura = [true,true,false,true,true];  
      protCampos.funciones = ['','','','','',''];
      protCampos.completar = ['off','off','off','off','off'];
      protCampos.opciones = ['','','','',''];
      for(var j=0, k = categoriaagendacampo.length; j < k; j++)
      {
        protCampos.agregarCampos(JSON.stringify(categoriaagendacampo[j]),'L');
        console.log(JSON.stringify(categoriaagendacampo[j]))
      }

    });

  </script>


	 @if(isset($categoriaagenda))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($categoriaagenda,['route'=>['categoriaagenda.destroy',$categoriaagenda->idCategoriaAgenda],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($categoriaagenda,['route'=>['categoriaagenda.update',$categoriaagenda->idCategoriaAgenda],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'categoriaagenda.store','method'=>'POST'])!!}
  @endif


<div id='form-section'>

  <fieldset id="categoriaagenda-form-fieldset"> 
      	<div class="form-group" id='test'>
	        {!!Form::label('codigoCategoriaAgenda', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
	      <div class="col-sm-10">
	        <div class="input-group">
	            <span class="input-group-addon">
	              <i class="fa fa-barcode"></i>
	            </span>
	            {!!Form::text('codigoCategoriaAgenda',null,['class'=>'form-control','placeholder'=>'Ingresa el código del tipo de tarea'])!!}
	          {!!Form::hidden('idCategoriaAgenda', null, array('id' => 'idCategoriaAgenda')) !!}
	          {!!Form::hidden('eliminarCategoriaAgenda', null, array('id' => 'eliminarCategoriaAgenda')) !!}
	        </div>
	      </div>
	    </div>


    
      	<div class="form-group" id='test'>
          {!!Form::label('nombreCategoriaAgenda', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
        	  {!!Form::text('nombreCategoriaAgenda',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del tipo de tarea'])!!}
            </div>
          </div>
      	</div>



      	<div class="form-group" id='test'>
	      {!!Form::label('colorCategoriaAgenda', 'Color', array('class' => 'col-sm-2 control-label')) !!}
	      <div class="col-sm-10">
	        <div class="input-group">
	          <span class="input-group-addon">
	              <i class="fa fa-sliders"></i>
	          </span>
	      	  <div id="colorFondoCategoriaAgenda" class="input-group colorpicker-component" style="width: 100%;">
        {!!Form::hidden('colorCategoriaAgenda', (isset($categoriaagenda) ? $categoriaagenda->colorCategoriaAgenda : '#255986'), array('id' => 'colorCategoriaAgenda')) !!}
			  <span class="input-group-addon"><i style="width: 100%;"></i></span>
			</div>
	      	  <script>
				  $(function () {
				      $('#colorFondoCategoriaAgenda').colorpicker();
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#permisoCategoriaAgenda">Contenido</a>
                      </h4>
                    </div>
                    <div id="permisoCategoriaAgenda" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                              <div class="col-md-1" style="width: 40px; height: 42px; cursor: pointer;" onclick="abrirModalCampos();">
                                <span class="glyphicon glyphicon-plus"></span>
                              </div>
                              <div class="col-md-1" style="width: 610px;">Campo</div>
                              <div class="col-md-1" style="width: 150px;">Obligatorio</div>
                              <div id="contenedor_protCampos"> 
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

	@if(isset($categoriaagenda))
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

<div id="ModalCampos" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Selecci&oacute;n de Campos</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="campos" name="campos" src="http://'.$_SERVER["HTTP_HOST"].'/campocrmgridselect"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>