@extends('layouts.grid')
@section('titulo')
    <h3 id="titulo">
        <center>Reporte ACPM</center>
    </h3>
@stop
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
                            <li><a class="toggle-vis" data-column="2"><label> N&uacute;mero</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Fecha</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Descripci&oacute;n</label></a></li>
                        </ul>
                    </div>
                    <table id="treporteacpm" name="treporteacpm" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:60px;padding: 1px 8px;" data-orderable="false">
                                 <a href="reporteacpm/create"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-plus"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>N&uacute;mero</b></th>
                                <th><b>Fecha</b></th>
                                <th><b>Descripci&oacute;n</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>N&uacute;mero</th>
                                <th>Fecha </th>
                                <th>Descripci&oacute;n</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

{!!Form::button('Limpiar filtros',["class"=>"btn btn-primary","id"=>'btnLimpiarFiltros'])!!}
<script type="text/javascript">

    function imprimirFormato(id)
    {
        window.open('reporteacpm/'+id+'?accion=imprimir','Formato','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
    }
    $(document).ready( function () {

        
        /*$('#tplancapacitacion').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosPlanCapacitacion')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var imprimir = '<?php echo (isset($datos[0]) ? $dato["consultarRolOpcion"] : 0);?>';
        var table = $('#treporteacpm').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
           "ajax": "{!! URL::to ('/datosReporteACPM?modificar="+modificar+"&eliminar="+eliminar+"&imprimir="+imprimir+"')!!}",
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

        $('#treporteacpm tbody')
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
    $('#treporteacpm tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tplancapacitacion thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#treporteacpm').DataTable();
 
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

        $('#btnLimpiarFiltros').click(function() 
        {
            that
                .search('')
                .draw();
        });
    })

    
});
    
</script>

@stop