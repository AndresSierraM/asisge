@extends('layouts.vista')

@section('titulo')<h3 id="titulo"><center>Reporte de condiciones y actos Inseguros</center></h3>@stop

@section('content')
  @include('alerts.request')


	@if(isset($actoinseguro))
		@if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
			{!!Form::model($actoinseguro,['route'=>['actoinseguro.destroy',$actoinseguro->idActoInseguro],'method'=>'DELETE'])!!}
		@else
			{!!Form::model($actoinseguro,['route'=>['actoinseguro.update',$actoinseguro->idActoInseguro],'method'=>'PUT'])!!}
		@endif
	@else
		{!!Form::open(['route'=>'actoinseguro.store','method'=>'POST'])!!}
	@endif

<script>

</script>

<div id='form-section' >
	<fieldset id="actoinseguro-form-fieldset">	
                                                                <!--Reportado Por  -->
                    <div class="form-group" id='test'>
                     {!!Form::label('Tercero_idEmpleadoReporta', 'Reportado Por', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6" style="padding-left:10px">
                                            <div class="input-group">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-user" style="width: 14px;" aria-hidden="true"></i>
                                                     </span>                  
                               {!!Form::select('Tercero_idEmpleadoReporta',$TerceroReporta, (isset($actoinseguro) ? $actoinseguro->Tercero_idEmpleadoReporta : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                               </div>
                                    </div>
                                                                      <!--Fecha Elaboracion Acto Inseguro  -->
                                  <div class="form-group" id='test'>
                                     {!!Form::label('fechaElaboracionActoInseguro', 'Fecha', array('class' => 'col-sm-1 control-label')) !!}
                                          <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                                                <div class="input-group" >
                                                       <span class="input-group-addon">
                                                              <i class="fa fa-calendar"  style="width: 14px;" aria-hidden="true"></i>
                                                       </span>
                          {!!Form::text('fechaElaboracionActoInseguro',(isset($actoinseguro) ? $actoinseguro->fechaElaboracionActoInseguro : null),['class'=> 'form-control','placeholder'=>'Seleccione la Fecha de Elaboraci&#243;n'])!!}
                                                   </div>
                                          </div>
                                 </div>
                    </div>
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                          <div class="panel panel-default">
                            <div class="panel-heading">&nbsp;</div>
                            <div class="panel-body">
                              <div class="panel-group" id="accordion">
                                                                                      <!--Descripci&#243;n de la condici&#243;n o acto inseguro observado  -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#decripcion">Descripci&#243;n</a>
                                    </h4>
                                  </div>
                                  <div id="decripcion" class="panel-collapse collapse ">
                                    <div class="panel-body">
                                      <div class="form-group" id='test'>
                                        <div class="col-md-10 col-sm-10 col-lg-10 col-xs-10" style="width: 100%;">
                                          <div class="input-group">
                                            {!!Form::textarea('descripcionActoInseguro',null,['class'=>'ckeditor','placeholder'=>'Ingresa la descripcion'])!!}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                
                                </div>
                                                                                  <!-- Cu&#225;les cree que son las posibles consecuencias -->
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#consecuencias">Consecuencias</a>

                                    </h4>
                                  </div>
                                  <div id="consecuencias" class="panel-collapse collapse">
                                    <div class="panel-body">
                                      <div class="form-group" id='test'>
                                        <div class="col-md-10 col-sm-10 col-lg-10 col-xs-10" style="width: 100%;">
                                          <div class="input-group">
                                            {!!Form::textarea('consecuenciasActoInseguro',null,['class'=>'ckeditor','placeholder'=>'Ingresa los objetivos'])!!}
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                
                                </div>
                                 <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion" href="#archivo">Adjuntos</a>
                                    </h4>
                                  </div>
                                  <div id="archivo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                      <div class="form-group" id='test'>
                                        <div class="col-md-10 col-sm-10 col-lg-10 col-xs-10" style="width: 100%;">
                                          <div class="input-group">
                                            <!-- Code Here -->
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
                                                                    <!--Reportado Por  -->
                    <div class="form-group" id='test'>
                     {!!Form::label('estadoActoInseguro', 'Estado', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6" style="padding-left:10px">
                                            <div class="input-group">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-bars" style="width: 14px;" aria-hidden="true"></i>
                                                     </span>                  
                               {!!Form::select('estadoActoInseguro',array('REGISTRADO'=>'Registrado','ANALISIS'=>'En análisis','RECHAZADO'=>'Rechazado','SOLUCIONADO'=>'Solucionado','PLANACCION'=>'En plan de acción'),(isset($actoinseguro) ? $actoinseguro->estadoActoInseguro : 0),["class" =>"form-control"])!!}
                                               </div>
                                    </div>
                                                                      <!--Fecha Solucion Acto Inseguro  -->
                                  <div class="form-group" id='test'>
                                     {!!Form::label('fechaSolucionActoInseguro', 'Fecha', array('class' => 'col-sm-1 control-label')) !!}
                                          <div class="col-md-3 col-sm-3 col-lg-3 col-xs-3">
                                                <div class="input-group" >
                                                       <span class="input-group-addon">
                                                              <i class="fa fa-calendar"  style="width: 14px;" aria-hidden="true"></i>
                                                       </span>
                          {!!Form::text('fechaSolucionActoInseguro',(isset($actoinseguro) ? $actoinseguro->fechaSolucionActoInseguro : null),['class'=> 'form-control','placeholder'=>'Seleccione la Fecha de Solucion'])!!}
                                                   </div>
                                          </div>
                                 </div>
                    </div>
                    <div class="form-group" id='test'>
                     {!!Form::label('Tercero_idEmpleadoSoluciona', 'Qui&#233;n Soluciona', array('class' => 'col-sm-2 control-label')) !!}
                                    <div class="col-md-6 col-sm-6 col-lg-6 col-xs-6" style="padding-left:10px">
                                            <div class="input-group">
                                                     <span class="input-group-addon">
                                                             <i class="fa fa-user" style="width: 14px;" aria-hidden="true"></i>
                                                     </span>                  
                               {!!Form::select('Tercero_idEmpleadoSoluciona',$TerceroSoluciona, (isset($actoinseguro) ? $actoinseguro->Tercero_idEmpleadoSoluciona : 0),["class" => "select form-control", "placeholder" =>"Seleccione"])!!}
                                               </div>
                                    </div>
                    </div>
    </fieldset>
    <br>
	@if(isset($actoinseguro))
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



<script>

 CKEDITOR.replace(('descripcionActoInseguro','consecuenciasActoInseguro'), {
        fullPage: true,
        allowedContent: true
      }); 

 $(document).ready( function () {

   $('#fechaElaboracionActoInseguro').datetimepicker(({
      format: "YYYY-MM-DD"
    }));
   $('#fechaSolucionActoInseguro').datetimepicker(({
      format: "YYYY-MM-DD"
    }));

  });

  

     
</script> 

@stop