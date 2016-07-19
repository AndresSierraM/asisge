@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Ausentismos</center></h3>@stop
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

    td.error {
        font-weight: bold;
        background-color: #FA5858;
        color: white;
    }

</style> 
<?php 
    $visible = '';

    $dato = get_object_vars($datos[0]);
    if ($dato['adicionarRolOpcion'] == 1) 
        $visible = 'inline-block;';
    else
        $visible = 'none;';
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
                            <li><a class="toggle-vis" data-column="1"><label> Descripción Ausencia</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Empleado</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Elaboración</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Desde</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Hasta</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Días</label></a></li>
                            <li><a class="toggle-vis" data-column="6"><label> Tipo Ausencia</label></a></li>
                            <li><a class="toggle-vis" data-column="7"><label> Accidente Relacionado</label></a></li>
                        </ul>
                    </div>
                    <table id="tausentismo" name="tausentismo" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;" data-orderable="false">
                                 <a href="ausentismo/create"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-plus"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>Descripción Ausencia</b></th>
                                <th><b>Empleado</b></th>
                                <th><b>Elaboración</b></th>
                                <th><b>Desde</b></th>
                                <th><b>Hasta</b></th>
                                <th><b>Días</b></th>
                                <th><b>Tipo Ausencia</b></th>
                                <th><b>Accidente Relacionado</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>Descripción Ausencia</th>
                                <th>Empleado</th>
                                <th>Elaboración</th>
                                <th>Desde</th>
                                <th>Hasta</th>
                                <th>Días</th>
                                <th>Tipo Ausencia</th>
                                <th>Ausencia Relacionada</th>
                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>


<script type="text/javascript">

    $(document).ready( function () {

        
        /*$('#tausentismo').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosAusentismo')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo $dato["modificarRolOpcion"];?>';
        var eliminar = '<?php echo $dato["eliminarRolOpcion"];?>';
        var table = $('#tausentismo').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
             "ajax": "{!! URL::to ('/datosAusentismo?modificar="+modificar+"&eliminar="+eliminar+"')!!}",
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
                    },
            "createdRow": function ( row, data, index ) {
                        if ( (data[6] == 'Accidente de Trabajo' || data[6] == 'Incidente de Trabajo') && data[7] == null ) {
                            $('td', row).eq(6).addClass('error');
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

        $('#tausentismo tbody')
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
    $('#tausentismo tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tausentismo thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tausentismo').DataTable();
 
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