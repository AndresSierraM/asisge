@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Consulta de Trazabilidad de Producción</center></h3>@stop
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
        <div  style="overflow: auto; margin: 10px 10px 10px 10px;">
            
                    <br>
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="1"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Número O.P.</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Fecha Elaboración</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Cliente</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Orden de Compra</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Referencia</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Especificaciones</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Secuencia</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Proceso</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Calidad</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Cantidad O.P</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Cantidad O.T</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Cantidad E.T</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Diferencia</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Estado</label></a></li>
                        </ul>
                    </div>
                    <table id="tconsultaordenproduccion" name="tconsultaordenproduccion" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>ID</b></th>
                                <th><b>Número O.P.</b></th>
                                <th><b>Fecha Elaboración</b></th>
                                <th><b>Cliente</b></th>
                                <th><b>Orden de Compra</b></th>
                                <th><b>Referencia</b></th>
                                <th><b>Especificaciones</b></th>
                                <th><b>Secuencia</b></th>
                                <th><b>Proceso</b></th>
                                <th><b>Calidad</b></th>
                                <th><b>Cantidad O.P</b></th>
                                <th><b>Cantidad O.T</b></th>
                                <th><b>Cantidad E.T</b></th>
                                <th><b>Diferencia</b></th>
                                <th><b>Estado</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th>ID</th>
                                <th>Número O.P.</th>
                                <th>Fecha Elaboración</th>
                                <th>Cliente</th>
                                <th>Orden de Compra</th>
                                <th>Referencia</th>
                                <th>Especificaciones</th>
                                <th>Secuencia</th>
                                <th>Proceso</th>
                                <th>Calidad</th>
                                <th>Cantidad O.P</th>
                                <th>Cantidad O.T</th>
                                <th>Cantidad E.T</th>
                                <th>Diferencia</th>
                                <th>Estado</th>
                            </tr>
                        </tfoot>        
                    </table>
               
        </div>


<script type="text/javascript">

    $(document).ready( function () {

        
        /*$('#tconsultaordenproduccion').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosConsultaOrdenProduccion')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var table = $('#tconsultaordenproduccion').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosConsultaOrdenProduccion?modificar="+modificar+"&eliminar="+eliminar+"')!!}",
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

        $('#tconsultaordenproduccion tbody')
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
    $('#tconsultaordenproduccion tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tconsultaordenproduccion thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tconsultaordenproduccion').DataTable();
 
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