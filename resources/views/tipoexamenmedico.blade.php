@extends('layouts.vista')
@section('titulo')<h3 id="titulo"><center>Tipo de Examen M&eacute;dico</center></h3>@stop

@section('content')
@include('alerts.request')

	@if(isset($tipoexamenmedico))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($tipoexamenmedico,['route'=>['tipoexamenmedico.destroy',$tipoexamenmedico->idTipoExamenMedico],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($tipoexamenmedico,['route'=>['tipoexamenmedico.update',$tipoexamenmedico->idTipoExamenMedico],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'tipoexamenmedico.store','method'=>'POST'])!!}
	@endif


<div id='form-section' >

	
	<fieldset id="tipoexamenmedico-form-fieldset">	
		  <div class="form-group required" id='test'>
          {!! Form::label('codigoTipoExamenMedico', 'C&oacute;digo', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::text('codigoTipoExamenMedico',null,['class'=>'form-control','placeholder'=>'Ingresa el código del Exámen médico'])!!}
              {!! Form::hidden('idTipoExamenMedico', null, array('id' => 'idTipoExamenMedico')) !!}
            </div>
          </div>
        </div>


		
		  <div class="form-group required" id='test'>
        {!! Form::label('nombreTipoExamenMedico', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-pencil-square-o "></i>
            </span>
      			{!!Form::text('nombreTipoExamenMedico',null,['class'=>'form-control','placeholder'=>'Ingresa el nombre del examen medico',"onchange"=>"this.value=quitarCaracterEspecial(this.value);"])!!}
          </div>
        </div>
      </div>

      <div class="form-group" id='test'>
        {!! Form::label('limiteInferiorTipoExamenMedico', 'L&iacute;mite Inferior', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar-o "></i>
            </span>
            {!!Form::text('limiteInferiorTipoExamenMedico',null,['class'=>'form-control','placeholder'=>'Ingresa el límite inferior del examen medico'])!!}
          </div>
        </div>
      </div>

      <div class="form-group" id='test'>
        {!! Form::label('limiteSuperiorTipoExamenMedico', 'L&iacute;mite Superior', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar-o "></i>
            </span>
            {!!Form::text('limiteSuperiorTipoExamenMedico',null,['class'=>'form-control','placeholder'=>'Ingresa el limite superior del examen medico'])!!}
          </div>
        </div>
      </div>

      <div class="form-group" id='test'>
        {!! Form::label('observacionTipoExamenMedico', 'Observaciones', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-addon">
              <i class="fa fa-calendar-o "></i>
            </span>
              {!!Form::textarea('observacionTipoExamenMedico',null,['class'=>'ckeditor','placeholder'=>'Ingresa las observacion del examen medico'])!!}
          </div>
        </div>
      </div>

     
    </fieldset>
	@if(isset($tipoexamenmedico))
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

<script>
    CKEDITOR.replace(('misionCompania','visionCompania','valoresCompania','politicasCompania','principiosCompania','metasCompania'), {
        fullPage: true,
        allowedContent: true
      });  
</script>

@stop