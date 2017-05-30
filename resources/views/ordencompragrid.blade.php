<?php 
$idDocumentoCRM = $_GET['idDocumentoCRM'];
$documento = DB::Select('SELECT nombreDocumentoCRM FROM documentocrm WHERE idDocumentoCRM = '.$idDocumentoCRM);
$titulo = get_object_vars($documento[0])['nombreDocumentoCRM'];
?>
@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Orden de Compra  <?php echo $titulo ?></center></h3>@stop
@section('content')
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
        <div class="container">
            <div class="row">
                <div class="container">
                    <br>
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> Iconos</label></a></li>
                            <li><a class="toggle-vis" data-column="1"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Numero</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Requerimientos</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Sitio de Entrega</label></a></li>
                            <li><a class="toggle-vis" data-column="6"><label> Elaboracion</label></a></li>
                            <li><a class="toggle-vis" data-column="7"><label> Vencimiento</label></a></li>
                            <li><a class="toggle-vis" data-column="8"><label> Proveedor</label></a></li>
                            <li><a class="toggle-vis" data-column="9"><label> Solicitante</label></a></li>
                            <li><a class="toggle-vis" data-column="10"><label> Autorizador</label></a></li>
                            <li><a class="toggle-vis" data-column="11"><label> Estado</label></a></li>
                        </ul>
                    </div>
                    <table id="tordencompra" name="tordencompra" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;" data-orderable="false">
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
        var idDocumentoCRM = '<?php echo $idDocumentoCRM?>';
        var table = $('#tordencompra').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosOrdenCompra?modificar="+modificar+"&eliminar="+eliminar+"&idDocumentoCRM="+idDocumentoCRM+"')!!}",
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

@stop