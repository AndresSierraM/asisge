<?php 
$idDocumentoCRM = $_GET['idDocumentoCRM'];
$documento = DB::Select('SELECT nombreDocumentoCRM FROM documentocrm WHERE idDocumentoCRM = '.$idDocumentoCRM);
$titulo = get_object_vars($documento[0])['nombreDocumentoCRM'];

$estado = (isset($_GET["estado"]) ? $_GET["estado"] : 'En Proceso');

// consultamos el tercero asociado al  usuario logueado, para 
// relacionarlo al campo de autorizador

$tercero  = DB::select(
    'SELECT idTercero, nombreCompletoTercero
    FROM tercero
    where idTercero = '.\Session::get('idTercero'));

$tercero = get_object_vars($tercero[0]); 
?>
@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Orden de Compra  <?php echo $titulo ?></center></h3>@stop
@section('content')
{!!Html::script('js/ordencompra.js'); !!}
<style>
    tfoot input {
                width: 100%;
                padding: 3px;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
</style> 
<?php 
    $visible = '';

    if (isset($datos[0])) 
    {
        $dato = get_object_vars($datos[0]);
        if ($dato['adicionarDocumentoCRMRol'] == 1) 
        {
            $visible = 'inline-block;';    
        }
        else
        {
            $visible = 'none;';
        }
    }
    else
    {
        $visible = 'none;';
    }
?>
<script type="text/javascript">
    var modificar = "<?php echo (isset($dato['modificarDocumentoCRMRol']) ? $dato['modificarDocumentoCRMRol'] : 0);?>";
    var eliminar = "<?php echo (isset($dato['anularDocumentoCRMRol']) ? $dato['anularDocumentoCRMRol'] : 0);?>";
    var consultar = "<?php echo (isset($dato['consultarDocumentoCRMRol']) ? $dato['consultarDocumentoCRMRol'] : 0);?>";
    var aprobar = "<?php echo (isset($dato['aprobarDocumentoCRMRol']) ? $dato['aprobarDocumentoCRMRol'] : 0);?>";

</script>
        <div class="container">
            <div class="row">
                <div class="container">
                    <br>
                    <a style="cursor: pointer;" onclick="cambiarEstado(<?php echo $idDocumentoCRM;?>,'En Proceso', modificar, eliminar, consultar, aprobar);" title="Mostrar Pendientes">
                        <img  src='images/iconoscrm/estado_proceso.png' style="width:28px; height:28px;">
                    </a>
                    <a style="cursor: pointer;" onclick="cambiarEstado(<?php echo $idDocumentoCRM;?>,'Rechazado', modificar, eliminar, consultar, aprobar);" title="Mostrar Rechazadas">
                        <img  src='images/iconoscrm/estado_fallido.png' style="width:28px; height:28px;">
                    </a>
                    <a style="cursor: pointer;" onclick="cambiarEstado(<?php echo $idDocumentoCRM;?>,'Aprobado', modificar, eliminar, consultar, aprobar);" title="Mostrar Aprobadas">
                        <img  src='images/iconoscrm/estado_exitoso.png' style="width:28px; height:28px;">
                    </a>
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> Iconos</label></a></li>
                            <li><a class="toggle-vis" data-column="1"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Numero</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Requerimientos</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Sitio de Entrega</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Elaboracion</label></a></li>
                            <li><a class="toggle-vis" data-column="6"><label> Vencimiento</label></a></li>
                            <li><a class="toggle-vis" data-column="7"><label> Proveedor</label></a></li>
                            <li><a class="toggle-vis" data-column="8"><label> Solicitante</label></a></li>
                            <li><a class="toggle-vis" data-column="9"><label> Autorizador</label></a></li>
                            <li><a class="toggle-vis" data-column="10"><label> Estado</label></a></li>
                        </ul>
                    </div>
                    <table id="tordencompra" name="tordencompra" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:80px;padding: 1px 8px;" data-orderable="false">
                                 <?php echo '<a href="ordencompra/create?idDocumentoCRM='.$idDocumentoCRM.'"><span style= "display:'.$visible.'" class="glyphicon glyphicon-plus"></span></a>'; ?>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>Numero</b></th>
                                <th><b>Requerimientos</b></th>
                                <th><b>Sitio de Entrega</b></th>
                                <th><b>Elaboracion</b></th>
                                <th><b>Vencimiento</b></th>
                                <th><b>Proveedor</b></th>
                                <th><b>Solicitante</b></th>
                                <th><b>Autorizador</b></th>
                                <th><b>Estado</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>Numero</th>
                                <th>Requerimientos</th>
                                <th>Sitio de Entrega</th>
                                <th>Elaboracion</th>
                                <th>Vencimiento</th>
                                <th>Proveedor</th>
                                <th>Solicitante</th>
                                <th>Autorizador</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>


<script type="text/javascript">

    $(document).ready( function () {

        
        /*$('#tordencompra').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosOrdenCompra')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarDocumentoCRMRol"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["anularDocumentoCRMRol"] : 0);?>';
        var consultar = '<?php echo (isset($dato["consultarDocumentoCRMRol"]) ? $dato["consultarDocumentoCRMRol"] : 0);?>';
        var aprobar = '<?php echo (isset($dato["aprobarDocumentoCRMRol"]) ? $dato["aprobarDocumentoCRMRol"] : 0);?>';
        var idDocumentoCRM = '<?php echo $idDocumentoCRM?>';
        var estado = '<?php echo $estado?>';
        var table = $('#tordencompra').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosOrdenCompra?modificar="+modificar+"&eliminar="+eliminar+"&aprobar="+aprobar+"&consultar="+consultar+"&idDocumentoCRM="+idDocumentoCRM+"&estado="+estado+"')!!}",
            "language": {
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "No se encontraron resultados",
                        "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
                        "sInfo":           "Registros del _START_ al _END_ de un total de _TOTAL_ ",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "Primero",
                            "sLast":     "&Uacute;ltimo",
                            "sNext":     "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    }
        });
         
        $('a.toggle-vis').on( 'click', function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr('data-column') );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        $('#tordencompra tbody')
        .on( 'mouseover', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            if ( colIdx !== lastIdx ) {
                $( table.cells().nodes() ).removeClass( 'highlight' );
                $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
            }
        } )
        .on( 'mouseleave', function () {
            $( table.cells().nodes() ).removeClass( 'highlight' );
        } );


        // Setup - add a text input to each footer cell
    $('#tordencompra tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tordencompra thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tordencompra').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'blur change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    })

    
});
    
</script>
<input type="hidden" id="token" value="{{csrf_token()}}"/>
@stop

<div id="modalAutorizador" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Aprobación de Orden de Compra</h4>
      </div>
      <div class="modal-body">
        <div class="container col-md-12"  style="height:200px;">

            <div class="col-sm-12">
                <div class="col-sm-4">
                    {!!Form::label('Autorizador', 'Autorizador', array())!!}
                </div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="hidden" id="token" value="{{csrf_token()}}"/>
                        {!!Form::hidden('idOrden',null, array("id"=>"idOrden"))!!}
                        {!!Form::hidden('Autorizador',$tercero["idTercero"] , array("id"=>"Autorizador"))!!}
                        {!!Form::text('nombreCompletoAutorizador',$tercero["nombreCompletoTercero"],['class'=>'form-control', 'readonly'=>'readonly'])!!}
                    </div>
                </div>
            </div>

            
            <div class="col-sm-12">
                <div class="col-sm-4">
                    {!!Form::label('fechaAprobacion', 'Fecha de Aprobación', array())!!}
                </div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </span>
                        {!!Form::text('fechaAprobacion',date('Y-m-d'),['readonly'=>'readonly', 'class'=>'form-control'])!!}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-4">
                    {!!Form::label('estadoOrden', 'Estado', array())!!}
                </div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-tasks"></i>
                        </span>
                        {!! Form::select('estadoOrden', ['Aprobado' => 'Aprobado','Rechazado' => 'Rechazado'],null,['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="col-sm-4">
                    {!!Form::label('observacionOrden', 'Observación', array())!!}
                </div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-pencil-square-o"></i>
                        </span>
                        {!!Form::textarea('observacionOrden',null,['class'=>'form-control','style'=>'height:80px'])!!}
                    </div>
                </div>
            </div>
                       


        </div>

      </div>
       <div class="modal-footer">
        
            <button type="button" class="btn btn-primary"  data-dismiss="modal" onclick="autorizarOrdenCompra();">Autorizar</button>
            <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>

      </div>
    </div>
  </div>
</div>