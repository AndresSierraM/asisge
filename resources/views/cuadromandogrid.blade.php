@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Cuadro de Mando</center></h3>@stop
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
                            <li><a class="toggle-vis" data-column="1"><label> N&uacute;mero</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Objetivo Estratégico</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Objetivos de los procesos</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Nombre del indicador</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Procesos involucrados</label></a></li>
                            <li><a class="toggle-vis" data-column="6"><label> Formula indicador</label></a></li>
                            <li><a class="toggle-vis" data-column="7"><label> Grafico</label></a></li>
                            <li><a class="toggle-vis" data-column="8"><label> Meta</label></a></li>
                            <li><a class="toggle-vis" data-column="9"><label> Frecuencia Medici&oacute;n</label></a></li>
                            <li><a class="toggle-vis" data-column="10"><label> Responsable Medici&oacute;n</label></a></li>
                            <li><a class="toggle-vis" data-column="11"><label> Compa&ntilde;&iacute;a</label></a></li>
                        </ul>
                    </div>
                    <table id="tcuadromando" name="tcuadromando" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;" data-orderable="false">
                                 <a href="cuadromando/create"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-plus"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>N&uacute;mero</b></th>
                                <th><b>Objetivo de la calidad</b></th>
                                <th><b>Objetivos de los procesos</b></th>
                                <th><b>Nombre del indicador</b></th>
                                <th><b>Procesos involucrados</b></th>
                                <th><b>Formula indicador</b></th>
                                <th><b>Grafico</b></th>
                                <th><b>Meta</b></th>
                                <th><b>Frecuencia Medici&oacute;n</b></th>
                                <th><b>Responsable Medici&oacute;n</b></th>
                                <th><b>Compa&ntilde;&iacute;a</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>N&uacute;mero</th>
                                <th>Objetivo de la calidad</th>
                                <th>Objetivos de los procesos</th>
                                <th>Nombre del indicador</th>
                                <th>Procesos involucrados</th>
                                <th>Formula indicador</th>
                                <th>Grafico</th>
                                <th>Meta</th>
                                <th>Frecuencia Medici&oacute;n</th>
                                <th>Responsable Medici&oacute;n</th>
                                <th>Compa&ntilde;&iacute;a</th>
                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>

{!!Form::button('Limpiar filtros',["class"=>"btn btn-primary","id"=>'btnLimpiarFiltros'])!!}
<script type="text/javascript">

    $(document).ready( function () {

        
        /*$('#tcuadromando').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosCuadroMando')!!}",
        });*/
        var lastIdx = null;
        var adicionar = '<?php echo (isset($datos[0]) ? $dato["adicionarRolOpcion"] : 0);?>';
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var table = $('#tcuadromando').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosCuadroMando?adicionar="+adicionar+"&modificar="+modificar+"&eliminar="+eliminar+"')!!}",
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

        $('#tcuadromando tbody')
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
    $('#tcuadromando tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tcuadromando thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tcuadromando').DataTable();
 
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