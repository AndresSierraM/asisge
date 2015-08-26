@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Compa&ntilde;&iacute;a</center></h3>@stop

@section('content')
@include('alerts.request')
{!!Html::script('js/compania.js')!!}

<script>

  var companiaObjetivos = '<?php echo (isset($compania) ? json_encode($compania->companiaobjetivos) : "");?>';
  companiaObjetivos = (companiaObjetivos != '' ? JSON.parse(companiaObjetivos) : '');
  var valor = [0,''];

  $(document).ready(function(){
    
    objetivos = new Atributos('objetivos','contenedor_objetivos','objetivos_');
    objetivos.campos = ['idCompaniaObjetivo','nombreCompaniaObjetivo'];
    objetivos.etiqueta = ['input','textarea'];
    objetivos.tipo = ['hidden',''];
    objetivos.estilo = ['','width: 950px; height: 80px;'];
    objetivos.clase = ['','form-control'];
    objetivos.sololectura = [false,false];

    for(var j=0, k = companiaObjetivos.length; j < k; j++)
    {
        objetivos.agregarCampos(JSON.stringify(companiaObjetivos[j]),'L');
    }

  });
</script>
	@if(isset($compania))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($compania,['route'=>['compania.destroy',$compania->idCompania],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($compania,['route'=>['compania.update',$compania->idCompania],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'compania.store','method'=>'POST'])!!}
	@endif

<div id='form-section' >

	
	<fieldset id="compania-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoCompania', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoCompania',null,['class'=>'form-control','placeholder'=>'Ingresa el código de la compania'])!!}
              {!! Form::hidden('id', null, array('id' => 'id')) !!}
            </div>
          </div>
        </div>


		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreCompania', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
				      {!!Form::text('nombreCompania',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre de la compania'])!!}
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
                        <a data-toggle="collapse" data-parent="#accordion" href="#mision">Misi&oacute;n</a>
                      </h4>
                    </div>
                    <div id="mision" class="panel-collapse collapse in">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('misionCompania',null,['class'=>'ckeditor','placeholder'=>'Ingresa la misión de la compania'])!!}
                            </div>
                          </div>
                        </div>  
                      </div> 
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#vision">Visi&oacute;n</a>
                      </h4>
                    </div>
                    <div id="vision" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                                {!!Form::textarea('visionCompania',null,['class'=>'ckeditor','placeholder'=>'Ingresa la visión de la compania'])!!}
                            </div>
                          </div>
                        </div>   
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#valores">Valores</a>
                      </h4>
                    </div>
                    <div id="valores" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('valoresCompania',null,['class'=>'ckeditor','placeholder'=>'Ingresa los valores de la compania'])!!}
                            </div>
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#politicas">Pol&iacute;ticas</a>
                      </h4>
                    </div>
                    <div id="politicas" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('politicasCompania',null,['class'=>'ckeditor','placeholder'=>'Ingresa las políticas de la compania'])!!}
                            </div>
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#principios">Principios</a>
                      </h4>
                    </div>
                    <div id="principios" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('principiosCompania',null,['class'=>'ckeditor','placeholder'=>'Ingresa los principios de la compania'])!!}
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                   <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#metas">Metas</a>
                      </h4>
                    </div>
                    <div id="metas" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-10" style="width: 100%;">
                            <div class="input-group">
                              {!!Form::textarea('metasCompania',null,['class'=>'ckeditor','placeholder'=>'Ingresa las metas de la compania'])!!}
                            </div>
                          </div>
                        </div> 
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#objetivos">Objetivos</a>
                      </h4>
                    </div>
                    <div id="objetivos" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                                <div class="col-md-1" style="width: 40px;" onclick="objetivos.agregarCampos(valor,'A')">
                                  <span class="glyphicon glyphicon-plus"></span>
                                </div>
                                <div class="col-md-1" style="width: 950px;">Objetivos</div>
                                <div id="contenedor_objetivos">
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
	@if(isset($compania))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif
	{!!Form::close()!!}
	</div>
</div>
<script>
    CKEDITOR.replace(('misionCompania','visionCompania','valoresCompania','politicasCompania','principiosCompania','metasCompania'), {
        fullPage: true,
        allowedContent: true
      });  
</script>
@stop