@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Perfil del cliente</center></h3>@stop

@section('content')
@include('alerts.request')

{!!Html::script('js/perfilcliente.js')!!}
{!!Form::open(['route'=>'perfilcliente.store','method'=>'POST'])!!}

<script type="text/javascript">
    $(document).ready(function(){
        consultarEdadTercero();
    });
</script>

<div id='form-section' >

    <fieldset id="perfilcliente-form-fieldset"> 

        <div class="form-group" id='test'>
            {!!Form::label('nombreCompletoTercero', 'Nombres', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-user"></i>
                    </span>
                    {!!Form::text('nombreCompletoTercero',$perfilcliente['nombreCompletoTercero'],['class'=>'form-control','readonly'])!!}
                </div>
            </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('edadTercero', 'Edad', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    {!!Form::text('edadTercero',null,['class'=>'form-control','readonly'])!!}
                    {!! Form::hidden('fechaNacimientoTercero', $perfilcliente['fechaNacimientoTercero'], array('id' => 'fechaNacimientoTercero')) !!}
                </div>
            </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('direccionTercero', 'Dirección', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-road"></i>
                    </span>
                    {!!Form::text('direccionTercero',$perfilcliente['direccionTercero'],['class'=>'form-control','readonly'])!!}
                </div>
            </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('telefonoTercero', 'Telefono', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-tty"></i>
                    </span>
                    {!!Form::text('telefonoTercero',$perfilcliente['telefonoTercero'],['class'=>'form-control','readonly'])!!}
                </div>
            </div>
        </div>

        <div class="form-group" id='test'>
            {!!Form::label('correoTercero', 'Correo', array('class' => 'col-sm-2 control-label'))!!}
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-at"></i>
                    </span>
                    {!!Form::text('correoTercero',$perfilcliente['correoElectronicoTercero'],['class'=>'form-control','readonly'])!!}
                </div>
            </div>
        </div>

        <br><br><br><br><br><br><br><br><br>

        <!-- <div class="form-group">
          <div class="col-md-12">
            <div class="panel panel-primary">
              <div class="panel-heading">Contenido</div>
              <div class="panel-body">
                <div class="panel-group" id="accordion">

                <ul class="nav nav-tabs"> 
                  <li class="active"><a data-toggle="tab" href="#detalles">Detalles</a></li>
                  <li><a data-toggle="tab" href="#divcasocrm">Casos CRM</a></li>
                  <li><a data-toggle="tab" href="#divadjuntos">Documentos Adjuntos</a></li>
                  <li><a data-toggle="tab" href="#divagenda">Agenda</a></li>
                </ul>

                <div class="tab-content">
                  
                  <div id="detalles" class="tab-pane fade in active">
1
                  </div>

                  <div id="divcasocrm" class="tab-pane fade">
2
                  </div>

                  <div id="divadjuntos" class="tab-pane fade">
3
                  </div>

                  <div id="divagenda" class="tab-pane fade">
4
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
    </div> -->
    <div class="panel panel-primary">
        <div class="panel-heading">Detalles del cliente</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div id="detalles">
                        
                        <div class="form-group" id='test'>
                            {!!Form::label('tipoIdentificacionTercero', 'Documento', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </span>
                                    {!!Form::text('tipoIdentificacionTercero',$perfilcliente['nombreTipoIdentificacion'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('documentoTercero', 'Número', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-barcode"></i>
                                    </span>
                                    {!!Form::text('documentoTercero',$perfilcliente['documentoTercero'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('nombreCiudadTercero', 'Ciudad', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-flag"></i>
                                    </span>
                                    {!!Form::text('nombreCiudadTercero',$perfilcliente['nombreCiudad'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('movil1Tercero', 'Móvil', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-mobile-phone"></i>
                                    </span>
                                    {!!Form::text('movil1Tercero',$perfilcliente['movil1Tercero'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('paginaWebTercero', 'Página web', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-laptop"></i>
                                    </span>
                                    {!!Form::text('paginaWebTercero',$perfilcliente['paginaWebTercero'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('nombreZonaTercero', 'Zona', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-bookmark"></i>
                                    </span>
                                    {!!Form::text('nombreZonaTercero',$perfilcliente['nombreZona'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('nombreSectorEmpresaTercero', 'Sector de empresa', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-university"></i>
                                    </span>
                                    {!!Form::text('nombreSectorEmpresaTercero',$perfilcliente['nombreSectorEmpresa'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id='test'>
                            {!!Form::label('nombreTerceroProducto', 'Nombre de producto', array('class' => 'col-sm-2 control-label'))!!}
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-hdd-o"></i>
                                    </span>
                                    {!!Form::text('nombreTerceroProducto',$perfilcliente['nombreTerceroProducto'],['class'=>'form-control','readonly'])!!}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Documentos adjuntos</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div id="documentos">
                        <?php
                            $documentos = DB::Select('
                                SELECT rutaTerceroArchivo
                                FROM terceroarchivo
                                WHERE Tercero_idTercero = '.$_GET['idTercero']);

                            if(count($documentos) > 0) 
                            {
                                for ($i=0; $i < count($documentos); $i++) 
                                { 
                                    $documento = get_object_vars($documentos[$i]);
                                    echo '
                                    <div class="col-lg-4 col-md-4">
                                        <div class="panel panel-yellow" style="border: 1px solid orange;">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-xs-3">
                                                        <a target="_blank" 
                                                            href="http://'.$_SERVER["HTTP_HOST"].'/imagenes'.$documento['rutaTerceroArchivo'].'">
                                                            <i class="fa fa-book fa-5x" style="color: gray;"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-xs-9 text-right">
                                                        <div>'.str_replace('/tercero/','',$documento['rutaTerceroArchivo']).'
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';   
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Casos CRM</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div id="casoscrm">
                        <?php 
                        $documentocrm = DB::Select('
                            SELECT idDocumentoCRM, nombreDocumentoCRM 
                            FROM movimientocrm m 
                            LEFT JOIN documentocrm d ON m.DocumentoCRM_idDocumentoCRM = d.idDocumentoCRM 
                            WHERE Tercero_idSolicitante = '.$_GET['idTercero']);

                            if (count($documentocrm) > 0) 
                            {
                                for ($i=0; $i < count($documentocrm); $i++) 
                                { 
                                    $nombdocumento = get_object_vars($documentocrm[$i]);

                                    echo '
                                    <div class="col-md-1" style="width: 40px; cursor:pointer" onclick="arirModalMovimiento('.$nombdocumento["idDocumentoCRM"].','.$_GET["idTercero"].')">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </div>
                                    <div class="col-md-1" style="width: 330px;">'.$nombdocumento["nombreDocumentoCRM"].'
                                    </div>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel-heading">Agenda</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <div id="agenda">

                        <div class="panel panel-primary">
                            <div class="panel-heading">Tareas</div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div id="tareas">
                                            <?php 
                                                $tareas = DB::Select('
                                                    SELECT 
                                                        asuntoAgenda, 
                                                        colorCategoriaAgenda 
                                                    FROM 
                                                        agenda a 
                                                        LEFT JOIN categoriaagenda ca on a.CategoriaAgenda_idCategoriaAgenda = ca.idCategoriaAgenda 
                                                    WHERE 
                                                        MovimientoCRM_idMovimientoCRM IS NULL');

                                                if (count($tareas) > 0) 
                                                {
                                                    for ($i=0; $i < count($tareas); $i++) 
                                                    { 
                                                        $tarea = get_object_vars($tareas[$i]);

                                                        echo '<div id="circulo" style="width: 15px; height: 15px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; background: '.$tarea["colorCategoriaAgenda"].'; display:inline-block;"></div>
                                                            <div style="display:inline-block">'.$tarea["asuntoAgenda"].'</div></br>';
                                                    }   
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="panel panel-primary">
                            <div class="panel-heading">Eventos</div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <div id="eventos">
                                            <?php 
                                                $eventos = DB::Select('
                                                    SELECT 
                                                        asuntoAgenda, 
                                                        colorCategoriaAgenda 
                                                    FROM 
                                                        agenda a 
                                                        LEFT JOIN categoriaagenda ca on a.CategoriaAgenda_idCategoriaAgenda = ca.idCategoriaAgenda 
                                                    WHERE 
                                                        MovimientoCRM_idMovimientoCRM IS NOT NULL');

                                                if (count($eventos) > 0) 
                                                {
                                                    for ($i=0; $i < count($eventos); $i++) 
                                                    { 
                                                        $evento = get_object_vars($eventos[$i]);

                                                        echo '<div id="circulo" style="width: 15px; height: 15px; -moz-border-radius: 50%; -webkit-border-radius: 50%; border-radius: 50%; background: '.$evento["colorCategoriaAgenda"].'; display:inline-block;"></div>
                                                            <div style="display:inline-block">'.$evento["asuntoAgenda"].'</div></br>';
                                                    }   
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>
   
    </fieldset>

{!! Form::close() !!}
</div>
@stop

<div id="modalMovimiento" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Movimientos CRM</h4>
      </div>
      <div class="modal-body">

        <div class="container">
            <div class="row">
                <div class="container">
                    <table id="tmovimiento" name="tmovimiento" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-primary active">
                                <th><b>Asunto</b></th>
                                <th><b>Numero</b></th>
                                <th><b>Fecha de Solicitud</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>Asunto</th>
                                <th>Numero</th>
                                <th>Fecha de Solicitud</th>
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