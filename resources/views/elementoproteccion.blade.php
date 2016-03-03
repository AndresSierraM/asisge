@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Elementos </br> de Protecci&oacute;n Personal</center></h3>@stop

@section('content')
@include('alerts.request')
	

  @if(isset($elementoproteccion))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($elementoproteccion,['route'=>['elementoproteccion.destroy',$elementoproteccion->idElementoProteccion],'method'=>'DELETE', 'files' => true])!!}
    @else
      {!!Form::model($elementoproteccion,['route'=>['elementoproteccion.update',$elementoproteccion->idElementoProteccion],'method'=>'PUT', 'files' => true])!!}
    @endif
  @else
    {!!Form::open(['route'=>'elementoproteccion.store','method'=>'POST', 'files' => true])!!}
  @endif



<div id='form-section'>

<div class="col-md-6">
	<fieldset id="elementoproteccion-form-fieldset">	
		<div class="form-group" id='test'>
          {!! Form::label('codigoElementoProteccion', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoElementoProteccion',null,['class'=>'form-control','placeholder'=>'Ingresa el c&oacute;digo del elemento proteccion'])!!}
              {!! Form::hidden('idElementoProteccion', null, array('id' => 'idElementoProteccion')) !!}
            </div>
          </div>
        </div>

		
		    <div class="form-group" id='test'>
          {!! Form::label('nombreElementoProteccion', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
    				{!!Form::text('nombreElementoProteccion',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('TipoElementoProteccion_idTipoElementoProteccion', 'Tipo EPP', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                    <div class="input-group">
                        <span class="input-group-addon">
                          <i class="fa fa-bars"></i>
                        </span>
                {!!Form::select('TipoElementoProteccion_idTipoElementoProteccion',$tipoelementoproteccion, (isset($elementoproteccion) ? $elementoproteccion->TipoElementoProteccion_idTipoElementoProteccion : 0),["class" => "chosen-select form-control", "placeholder" =>"Seleccione el tipo de EPP"])!!}
              </div>
            </div>
          </div>

         <div class="form-group" id='test'>
          {!! Form::label('normaElementoProteccion', 'Norma', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-gavel"></i>
              </span>
            {!!Form::textarea('normaElementoProteccion',null,['class'=>'form-control','style'=>'height:100px','placeholder'=>''])!!}
            </div>
          </div>
        </div>
</div>


<div class="col-md-6">
        <div class="form-group" style="width:250px; display: inline;" >
        {!! Form::label('imagenElementoProteccion', '&nbsp;', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10" style="width:250px;">
            <div class="panel panel-default">
              <input id="imagenElementoProteccion" name="imagenElementoProteccion" type="file" value="<?php echo (isset($elementoproteccion->imagenElementoProteccion) ? 'imagenes/'. $elementoproteccion->imagenElementoProteccion : ''); ?>" >
            </div>
          </div>
        </div>
</div>
</br></br></br></br></br></br></br></br></br>
      <!-- Acordeon -->
      <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-default">
              <div class="panel-heading">Detalles</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#descripcion">Descripci&oacute;n</a>
                      </h4>
                    </div>
                    <div id="descripcion" class="panel-collapse collapse">
                      <div class="panel-body">

                           <div class="form-group" id='test'>
                            <!-- {!!Form::label('descripcionElementoProteccion', '&nbsp;', array('class' => 'col-sm-2 control-label')) !!} -->
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon">
                                  <i class="fa fa-pencil-square-o "></i>
                                </span>
                                {!!Form::textarea('descripcionElementoProteccion',null,['class'=>'form-control','style'=>'height:125px','placeholder'=>''])!!}
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div> 
                    </div>

                  <div class="panel panel-default">
                    <div class="panel-heading">

                      <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#procesos">Procesos</a>
                      </h4>
                    </div>
                   <div id="procesos" class="panel-collapse collapse">
                      <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="panel-body">
                            <div class="form-group" id='test'>
                              <!-- {!!Form::label('procesosElementoProteccion', '&nbsp;', array('class' => 'col-sm-2 control-label')) !!} -->
                              <div class="col-sm-10">
                                <div class="input-group">
                                  <span class="input-group-addon">
                                    <i class="fa fa-pencil-square-o "></i>
                                  </span>
                                  {!!Form::textarea('procesosElementoProteccion',null,['class'=>'form-control','style'=>'height:125px','placeholder'=>''])!!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>  
                      </div>
                    </div>
                  </div >  
                </div>
              </div>
            </div>
        </div>
      </div>

    </fieldset>
	@if(isset($elementoproteccion))
 		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
   			{!!Form::submit('Eliminar',["class"=>"btn btn-primary"])!!}
  		@else
   			{!!Form::submit('Modificar',["class"=>"btn btn-primary"])!!}
  		@endif
 	@else
  		{!!Form::submit('Adicionar',["class"=>"btn btn-primary"])!!}
 	@endif
	{!! Form::close() !!}
  <script type="text/javascript">
    document.getElementById('contenedor').style.width = '1350px';
    document.getElementById('contenedor-fin').style.width = '1350px';
        

    $('#imagenElementoProteccion').fileinput({
      language: 'es',
      uploadUrl: '#',
      allowedFileExtensions : ['jpg', 'png','gif'],
       initialPreview: [
       '<?php if(isset($elementoproteccion->imagenElementoProteccion))
            echo Html::image("imagenes/". $elementoproteccion->imagenElementoProteccion,"Imagen no encontrada",array("style"=>"width:148px;height:158px;"));
                           ;?>'
            ],
      dropZoneTitle: 'Seleccione',
      removeLabel: '',
      uploadLabel: '',
      browseLabel: '',
      uploadClass: "",
      uploadLabel: "",
      uploadIcon: "",
    });
    </script>
</div>
@stop