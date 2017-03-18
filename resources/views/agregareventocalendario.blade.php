@extends('layouts.modal')
@section('titulo')<h3 id="titulo"><center>Agenda</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/agenda.js')!!}

<script>

    var consultarTercero = ['onchange','consultarTercero(this.id, this.value)'];

    var agendaasistente = '<?php echo (isset($agenda) ? json_encode($agenda->agendaasistente) : "");?>';
    agendaasistente = (agendaasistente != '' ? JSON.parse(agendaasistente) : '');

    var valorAgendaAsistente = [0, 0, '', '', 0];

    $(document).ready(function(){

      asistente = new Atributos('asistente','contenedor_asistente','agendaasistente');

      asistente.altura = '35px';
      asistente.campoid = 'idAgendaAsistente';
      asistente.campoEliminacion = 'eliminarAgendaAsistente';

      asistente.campos   = [
      'idAgendaAsistente',
      'Tercero_idAsistente',
      'nombreAgendaAsistente',
      'correoElectronicoAgendaAsistente',
      'Agenda_idAgenda'
      ];

      asistente.etiqueta = [
      'input',
      'input',
      'input',
      'input',
      'input'
      ];

      asistente.tipo = [
      'hidden',
      'hidden',
      'text',
      'text',
      'hidden'
      ];

      asistente.estilo = [
      '',
      '',
      'width: 310px;height:35px;',
      'width: 150px;height:35px;',
      ''
      ];

      asistente.clase    = ['','','','','','','',''];
      asistente.sololectura = [true,true,false,false,true];  
      asistente.funciones = ['','','',consultarTercero,'',''];
      asistente.completar = ['off','off','off','off','off'];
      asistente.opciones = ['','','','',''];
      for(var j=0, k = agendaasistente.length; j < k; j++)
      {
        asistente.agregarCampos(JSON.stringify(agendaasistente[j]),'L');
        // llenarDatosCampo($('#CampoCRM_idCampoCRM'+j).val(), j);
      }

    });

  </script>

  <script>

    var agendaseguimiento = '<?php echo (isset($agenda) ? json_encode($agenda->agendaseguimiento) : "");?>';
    agendaseguimiento = (agendaseguimiento != '' ? JSON.parse(agendaseguimiento) : '');

    var valorAgendaSeguimiento = [0, 0, '', '', 0];

    $(document).ready(function(){

      seguimiento = new Atributos('seguimiento','contenedor_seguimiento','agendaseguimiento');

      seguimiento.altura = '35px';
      seguimiento.campoid = 'idAgendaSeguimiento';
      seguimiento.campoEliminacion = 'eliminarAgendaSeguimiento';

      seguimiento.campos   = [
      'idAgendaSeguimiento',
      'Agenda_idAgenda',
      'fechaHoraAgendaSeguimiento',
      'detallesAgendaSeguimiento',
      'Users_idCrea'
      ];

      seguimiento.etiqueta = [
      'input',
      'input',
      'input',
      'input',
      'input'
      ];

      seguimiento.tipo = [
      'hidden',
      'hidden',
      'text',
      'text',
      'hidden'
      ];

      seguimiento.estilo = [
      '',
      '',
      'width: 150px;height:35px;',
      'width: 310px;height:35px;',
      ''
      ];

      seguimiento.clase    = ['','','','','','','',''];
      seguimiento.sololectura = [true,true,false,false,true];  
      seguimiento.funciones = ['','','','','',''];
      seguimiento.completar = ['off','off','off','off','off'];
      seguimiento.opciones = ['','','','',''];
      for(var j=0, k = agendaseguimiento.length; j < k; j++)
      {
        seguimiento.agregarCampos(JSON.stringify(agendaseguimiento[j]),'L');
        // llenarDatosCampo($('#CampoCRM_idCampoCRM'+j).val(), j);
      }

    });

  </script>


   @if(isset($agenda))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($agenda,['route'=>['agenda.destroy',$agenda->idAgenda],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($agenda,['route'=>['agenda.update',$agenda->idAgenda],'method'=>'PUT'])!!}
    @endif
  @else
      {!!Form::open(['route'=>'agenda.store','method'=>'POST', 'action' => 'AgendaController@store', 'id' => 'agenda'])!!}
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
              {!!Form::select('CategoriaAgenda_idCategoriaAgenda',$categoriaagenda, (isset($agenda) ? $agenda->CategoriaAgenda_idCategoriaAgenda : 0),["class" => "form-control", "placeholder" =>"Seleccione tipo", 'onchange'=>'consultarCamposAgenda(this.value)'])!!}
            {!!Form::hidden('idAgenda', null, array('id' => 'idAgenda')) !!}
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


      <br><br><br><br><br>

      <div class="form-group" id='MovimientoCRM_idMovimientoCRM' style='display:none;'>
          {!!Form::label('MovimientoCRM_idMovimientoCRM', 'Caso CRM', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-bars"></i>
              </span>
              {!!Form::select('MovimientoCRM_idMovimientoCRM',$casocrm, (isset($agenda) ? $agenda->MovimientoCRM_idMovimientoCRM : 0),["class" => "form-control", "placeholder" =>"Seleccione un caso del CRM"])!!}  
          </div>
        </div>
      </div>

        <div class="form-group" id='ubicacionAgenda' style='display:none;'>
          {!!Form::label('ubicacionAgenda', 'Ubicación', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group" >
             <span class="input-group-addon">
                <i class="fa fa-sitemap" aria-hidden="true"></i>
             </span>
              {!!Form::text('ubicacionAgenda',null,['class'=> 'form-control','placeholder'=>'Ingrese la ubicacion'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='Tercero_idResponsable' style='display:none;'>
          {!!Form::label('Tercero_idResponsable', 'Responsable', array('class' => 'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          <div class="input-group">
              <span class="input-group-addon">
                <i class="fa fa-user"></i>
              </span>
              {!!Form::select('Tercero_idResponsable',$responsable, (isset($agenda) ? $agenda->Tercero_idResponsable : 0),["class" => "form-control", "placeholder" =>"Seleccione un responsable"])!!}  
          </div>
        </div>
      </div>

        <div class="form-group" id='porcentajeEjecucionAgenda' style='display:none;'>
          {!!Form::label('porcentajeEjecucionAgenda', '% Ejecución', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group" >
             <span class="input-group-addon">
                <i class="" aria-hidden="true">%</i>
             </span>
              {!!Form::text('porcentajeEjecucionAgenda',null,['class'=> 'form-control','placeholder'=>'Ingrese el porcentaje ejecutado'])!!}
            </div>
          </div>
        </div>

        <div class="form-group" id='estadoAgenda' style='display:none;'>
          {!!Form::label('estadoAgenda', 'Estado', array('class' => 'col-sm-2 control-label')) !!}
          <div class="col-sm-10">
            <div class="input-group" >
             <span class="input-group-addon">
                <i class="fa fa-tasks" aria-hidden="true"></i>
             </span>
              {!! Form::select('estadoAgenda', ['Sin finalizar' => 'Sin finalizar', 'Finalizado' => 'Finalizado'],null,['class' => 'form-control', 'placeholder' => 'Seleccione un estado']) !!}
            </div>
          </div>
        </div>

        <br><br><br><br><br><br><br><br><br><br><br>

        <div class="form-group">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Contenido</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">

                <ul class="nav nav-tabs"> <!--Pestañas de navegacion-->
                  <li class="active"><a data-toggle="tab" href="#detalles">Detalles</a></li>
                  <li id="liseguimiento" style="display:none;"><a data-toggle="tab" href="#divseguimiento">Seguimiento</a></li>
                  <li id="liasistentes" style="display:none;"><a data-toggle="tab" href="#divasistentes">Asistentes</a></li>
                </ul>

                <div class="tab-content">
                  
                  <div id="detalles" class="tab-pane fade in active">

                    <div class="form-group" id='test'>
                      
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                          </span>
                          {!!Form::textarea('detallesAgenda',null,['class'=>'form-control','style'=>'height:100px;','placeholder'=>'Ingresa el detalle de la agenda'])!!}
                        </div>
                      </div>
                    </div>

                  </div>

                  <div id="divseguimiento" class="tab-pane fade" style="display:none;">

                    <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                              <div class="col-md-1" style="width: 40px; height: 42px; cursor: pointer;" onclick="seguimiento.agregarCampos(valorAgendaSeguimiento,'A')">
                                <span class="glyphicon glyphicon-plus"></span>
                              </div>
                              <div class="col-md-1" style="width: 150px;">Fecha</div>
                              <div class="col-md-1" style="width: 310px;">Detalles</div>
                              <div id="contenedor_seguimiento"> 
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                  </div>

                  <div id="divasistentes" style="display:none;" class="tab-pane fade">

                    <div class="panel-body">
                        <div class="form-group" id='test'>
                          <div class="col-sm-12">
                            <div class="row show-grid">
                              <div class="col-md-1" style="width: 40px; height: 42px; cursor: pointer;" onclick="asistente.agregarCampos(valorAgendaAsistente,'A')">
                                <span class="glyphicon glyphicon-plus"></span>
                              </div>
                              <div class="col-md-1" style="width: 310px;">Nombre</div>
                              <div class="col-md-1" style="width: 150px;">Correo Electrónico</div>
                              <div id="contenedor_seguimiento"> 
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
      {!!Form::submit('Adicionar',["class"=>"btn btn-primary",'onclick'=>'validarFormulario(event);'])!!}
  @endif

  {!! Form::close() !!}
</div>
<script>
  // CKEDITOR.replace(('detallesAgenda'), {
  //     fullPage: true,
  //     allowedContent: true
  //   });  

  $('#fechaHoraInicioAgenda').datetimepicker(({
      format: "DD-MM-YYYY HH:mm:ss"
    }));

    $('#fechaHoraFinAgenda').datetimepicker(({
      format: "DD-MM-YYYY HH:mm:ss"
    }));
</script>
@stop

<div id="modalTercero" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:50%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Seleccionar terceros</h4>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
              <div class="container">                      
                <table id="tlistaselect" name="tlistaselect" class="display table-bordered" width="100%">
                  <thead>
                    <tr class="btn-primary active">
                      <th><b>Nombre</b></th>
                      <th><b>Correo</b></th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr class="btn-default active">
                      <th>Nombre</th>
                      <th>Correo</th>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>