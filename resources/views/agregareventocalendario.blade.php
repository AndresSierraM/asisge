@extends('layouts.modal')
@section('titulo')<h3 id="titulo"><center>Agenda</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/modalagenda.js')!!}
<!-- Librerías para el selector de colores (color Picker) -->
{!! Html::style('assets/colorpicker/css/bootstrap-colorpicker.min.css'); !!}
{!! Html::script('assets/colorpicker/js/bootstrap-colorpicker.js'); !!}


<script>

    var categoriaagendacampo = '<?php echo (isset($agenda) ? json_encode($agenda->categoriaagendacampo) : "");?>';
    categoriaagendacampo = (categoriaagendacampo != '' ? JSON.parse(categoriaagendacampo) : '');

    var valorAgenda = ['','', 0];

    $(document).ready(function(){

      protCampos = new Atributos('protCampos','contenedor_protCampos','categoriaagendacampo');

      protCampos.altura = '35px';
      protCampos.campoid = 'idAgendaCampo';
      protCampos.campoEliminacion = 'eliminarAgenda';

      protCampos.campos   = [
      'idAgendaCampo',
      'CampoCRM_idCampoCRM',
      'nombreCampoCRM',
      'obligatorioAgendaCampo',
      'Agenda_idAgenda'
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
        llenarDatosCampo($('#CampoCRM_idCampoCRM'+j).val(), j);
      }

    });

  </script>


   @if(isset($agenda))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($agenda,['route'=>['agenda.destroy',$agenda->idagenda],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($agenda,['route'=>['agenda.update',$agenda->idagenda],'method'=>'PUT'])!!}
    @endif
  @else
      {!!Form::open(['route'=>'agenda.store','method'=>'POST', 'action' => 'AgendaController@store', 'id' => 'agenda' , 'files' => true])!!}
  @endif


<div id='form-section'>
<input type="hidden" id="token" value="{{csrf_token()}}"/>
  <fieldset id="agenda-form-fieldset"> 

        <div class="form-group" id='test'>
          {!!Form::label('CategoriaAgenda_idCategoriaAgenda', 'Tipo', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-barcode"></i>
              </span>
              {!!Form::select('CategoriaAgenda_idCategoriaAgenda',$categoriaagenda, (isset($agenda) ? $agenda->CategoriaAgenda_idCategoriaAgenda : 0),["class" => "form-control", "placeholder" =>"Seleccione tipo"])!!}
            {!!Form::hidden('idAgenda', null, array('id' => 'idAgenda')) !!}
            {!!Form::hidden('eliminarAgenda', null, array('id' => 'eliminarAgenda')) !!}
          </div>
        </div>
      </div>


    
        <div class="form-group" id='test'>
          {!!Form::label('asuntoAgenda', 'Nombre', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-pencil-square-o "></i>
              </span>
            {!!Form::text('asuntoAgenda',null,['class'=>'form-control','placeholder'=>'Ingresa el asunto de la agenda'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='test'>
           {!!Form::label('fechaHoraInicioAgenda', 'Fecha Inicial', array('class' => 'col-sm-2 control-label')) !!}
            <div class="col-sm-10">
                <div class="input-group">
                   <span class="input-group-addon">
                      <i class="fa fa-calendar" aria-hidden="true"></i>
                   </span>
                    {!!Form::text('fechaHoraInicioAgenda',null,['class'=> 'form-control','placeholder'=>'Ingrese la fecha inicial'])!!}
                 </div>
            </div>
        </div>

        <div class="form-group" id='test'>
          {!!Form::label('fechaHoraFinAgenda', 'Fecha Final', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group" >
             <span class="input-group-addon">
                <i class="fa fa-calendar" aria-hidden="true"></i>
             </span>
              {!!Form::text('fechaHoraFinAgenda',null,['class'=> 'form-control','placeholder'=>'Ingrese la fecha final'])!!}
            </div>
          </div>
         </div>

        <div class="form-group" id='test'>
          {!!Form::label('Tercero_idSupervisor', 'Supervisor', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-user"></i>
              </span>
              {!!Form::select('Tercero_idSupervisor',$supervisor, (isset($agenda) ? $agenda->Tercero_idSupervisor : 0),["class" => "form-control", "placeholder" =>"Seleccione el supervisor"])!!}
          </div>
        </div>
      </div>


      <br><br><br>

        <div class="form-group">
          <div class="col-lg-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Contenido</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">

                <ul class="nav nav-tabs"> <!--Pestañas de navegacion-->
                  <li class="active"><a data-toggle="tab" href="#detalles">Detalles</a></li>
                  <li><a data-toggle="tab" href="#seguimiento">Seguimiento</a></li>
                  <li><a data-toggle="tab" href="#asistentes">Asistentes</a></li>
                </ul>

                <div class="tab-content">
                  
                  <div id="detalles" class="tab-pane fade in active">

                    <div class="form-group" id='test'>
                      
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                          </span>
                          {!!Form::textarea('detallesAgenda',null,['class'=>'form-control ckeditor','style'=>'height:100px;','placeholder'=>'Ingresa el detalle de la agenda'])!!}
                        </div>
                      </div>
                    </div>

                  </div>

                  <div id="seguimiento" class="tab-pane fade">

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

                  <div id="asistentes" class="tab-pane fade">

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

  @if(isset($agenda))
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
  CKEDITOR.replace(('detallesAgenda'), {
      fullPage: true,
      allowedContent: true
    });  

  $('#fechaHoraInicioAgenda').datetimepicker(({
      format: "YYYY-MM-DD HH:mm:ss"
    }));

    $('#fechaHoraFinAgenda').datetimepicker(({
      format: "YYYY-MM-DD HH:mm:ss"
    }));
</script>
@stop