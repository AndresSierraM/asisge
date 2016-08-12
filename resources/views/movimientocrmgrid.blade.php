<?php 

$id = isset($_GET["idDocumentoCRM"]) ? $_GET["idDocumentoCRM"] : 0; 
$campos = DB::select(
    'SELECT codigoDocumentoCRM, nombreDocumentoCRM, nombreCampoCRM,descripcionCampoCRM, 
            mostrarGridDocumentoCRMCampo, relacionTablaCampoCRM, relacionNombreCampoCRM, relacionAliasCampoCRM
    FROM documentocrm
    left join documentocrmcampo
    on documentocrm.idDocumentoCRM = documentocrmcampo.DocumentoCRM_idDocumentoCRM
    left join campocrm
    on documentocrmcampo.CampoCRM_idCampoCRM = campocrm.idCampoCRM
    where documentocrm.idDocumentoCRM = '.$id.' and mostrarGridDocumentoCRMCampo = 1');

$camposGrid = 'idMovimientoCRM, numeroMovimientoCRM, asuntoMovimientoCRM';
$camposBase = 'idMovimientoCRM,numeroMovimientoCRM,asuntoMovimientoCRM';
$titulosGrid = 'ID, Número, Asunto';
for($i = 0; $i < count($campos); $i++)
{
    $datos = get_object_vars($campos[$i]); 
    
    $camposGrid .= ', '. $datos["relacionTablaCampoCRM"].'.'.$datos["relacionNombreCampoCRM"]  .
                     ($datos["relacionAliasCampoCRM"] == null 
                        ? ''
                        : ' As '. $datos["relacionAliasCampoCRM"]);

    $camposBase .= ','.($datos["relacionAliasCampoCRM"] == null 
                        ? $datos["relacionNombreCampoCRM"]
                        : $datos["relacionAliasCampoCRM"]);

    $titulosGrid .= ', '. $datos["descripcionCampoCRM"];
}


?>
@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center><?php echo '('.$datos["codigoDocumentoCRM"].') '.$datos["nombreDocumentoCRM"];?></center></h3>@stop
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
                            <?php 
                                $titulos = explode(',', $titulosGrid);
                                for($i = 0; $i < count($titulos); $i++)
                                {
                                    echo '<li><a class="toggle-vis" data-column="'.($i+1).'"><label> '.$titulos[$i].'</label></a></li>';
                                }
                            ?>

                           
                        </ul>
                    </div>
                    <table id="tmovimientocrm" name="tmovimientocrm" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;" data-orderable="false">
                                <a href=<?php echo "movimientocrm/create?idDocumentoCRM=".$id;?>><span  class="glyphicon glyphicon-plus"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <?php 
                                    for($i = 0; $i < count($titulos); $i++)
                                    {
                                        echo '<th><b>'.$titulos[$i].'</b></th>';
                                    }
                                ?>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <?php 
                                    for($i = 0; $i < count($titulos); $i++)
                                    {
                                        echo '<th>'.$titulos[$i].'</th>';
                                    }
                                ?>
                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>


<script type="text/javascript">

    $(document).ready( function () {
        var id = "<?php echo $id;?>";
        var camposBase = "<?php echo $camposBase;?>";
        var camposGrid = "<?php echo $camposGrid;?>";

        var lastIdx = null;
        var table = $('#tmovimientocrm').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosMovimientoCRM?idDocumento="+id+"&camposBase="+camposBase+"&camposGrid="+camposGrid+"')!!}",
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

        $('#tmovimientocrm tbody')
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
    $('#tmovimientocrm tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tmovimientocrm thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tmovimientocrm').DataTable();
 
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