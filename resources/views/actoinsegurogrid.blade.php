@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Reporte de condiciones y actos Inseguros</center></h3>@stop
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
        if ($dato['adicionarRolOpcion'] == 1) 
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
                            <li><a class="toggle-vis" data-column="2"><label> Reportado Por</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Fecha Elaboraci&#243;n</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Estado</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Fecha Soluci&#243;n</label></a></li>
                            <li><a class="toggle-vis" data-column="6"><label> Quien Soluciona</label></a></li>        
                        </ul>
                    </div>
                    <table id="tactoinseguro" name="tactoinseguro" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:60px;padding: 1px 8px;" data-orderable="false">
                                 <a href="actoinseguro/create"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-plus"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>Reportado Por</b></th>
                                <th><b>Fecha Elaboraci&#243;n</b></th>
                                <th><b>Estado</b></th>
                                <th><b>Fecha Soluci&#243;n</b></th>
                                <th><b>Quien Soluciona</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>Reportado Por</th>
                                <th>Fecha Elaboraci&#243;n</th>
                                <th>Estado</th>
                                <th>Fecha Soluci&#243;n</th>
                                <th>Quien Soluciona</th>
                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>

<script type="text/javascript">
// Se llama la funcion para  el formato de impresión
    $(document).ready( function () {

        
        /*$('#tactoinseguro').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosCargo')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var table = $('#tactoinseguro').DataTable( {
          
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosActoInseguro?modificar="+modificar+"&eliminar="+eliminar+"')!!}",
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

        $('#tactoinseguro tbody')
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
    $('#tactoinseguro tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tactoinseguro thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tactoinseguro').DataTable();
 
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