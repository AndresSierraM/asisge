@extends('layouts.calendario')
@section('titulo')<h3 id="titulo"><center>Agenda</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/agenda.js')!!}

   @if(isset($agenda))
    @if(isset($_GET['accion']) and $_GET['accion'] == 'eliminar')
      {!!Form::model($agenda,['route'=>['agenda.destroy',$agenda->idAgenda],'method'=>'DELETE'])!!}
    @else
      {!!Form::model($agenda,['route'=>['agenda.update',$agenda->idAgenda],'method'=>'PUT'])!!}
    @endif
  @else
    {!!Form::open(['route'=>'agenda.store','method'=>'POST'])!!}
  @endif


<div id='form-section'>
<input type="hidden" id="token" value="{{csrf_token()}}"/>
  <fieldset id="agenda-form-fieldset"> 

    <div class="row">
        <button type="button" onclick="agregarEvento()" class="btn btn-primary">Añadir evento</button>

      <div class="page-header">
        <div class="pull-right form-inline">
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-calendar-nav="prev"><< Anterior</button>
            <button type="button" class="btn" data-calendar-nav="today">Hoy</button>
            <button type="button" class="btn btn-primary" data-calendar-nav="next">Siguiente >></button>
          </div>
          <div class="btn-group">
            <button type="button" class="btn btn-warning" data-calendar-view="year">Año</button>
            <button type="button" class="btn btn-warning active" data-calendar-view="month">Mes</button>
            <button type="button" class="btn btn-warning" data-calendar-view="week">Semana</button>
            <button type="button" class="btn btn-warning" data-calendar-view="day">Día</button>
          </div>
        </div>
      </div>  
    </div>

    <div class="row">
      <div id="calendar"></div>
    </div>

  </fieldset>

  {!! Form::close() !!}
</div>
@stop
<div id="modalEvento" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Crear un nuevo evento</h4>
      </div>
      <div class="modal-body">
      <?php 
        echo '<iframe style="width:100%; height:400px; " id="campos" name="campos" src="http://'.$_SERVER["HTTP_HOST"].'/eventoagenda"></iframe>'
      ?>
      </div>
    </div>
  </div>
</div>