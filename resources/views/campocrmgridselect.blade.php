@extends('layouts.modal') 
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
<?php $tipo =  $_GET['tipo'];?>
        <div class="container">
            <div class="row">
                <div class="container">
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button  type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                       <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Campo</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Grid</label></a></li>
                            <li><a class="toggle-vis" data-column="0"><label> Oblig</label></a></li>
                            
                        </ul>
                    </div>
                    
                    <table id="tcampoSelect" name="tcampoSelect" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">

                                <th><b>ID</b></th>
                                <th><b>Campo</b></th>  
                                <th><b>Grid</b></th>  
                                <th><b>Oblig</b></th>        
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">

                                <th>ID</th>
                                <th>Campo</th>  
                                <th>Grid</th>                             
                                <th>Oblig</th>  
                            </tr>
                        </tfoot>
                    </table>

                    <div class="modal-footer">
                        <button id="botonCampo" name="botonCampo" type="button" class="btn btn-primary" >Seleccionar</button>
                    </div>

                

                </div>
            </div>
        </div>


<script type="text/javascript">

    $(document).ready( function () {

        var lastIdx = null;
        var tipo = '<?php echo $tipo;?>';
        var table = $('#tcampoSelect').DataTable( {
            "order": [[ 1, "asc" ]],
             "columnDefs": [
                    {
                        "targets": [ 2 ],
                        "visible": false,
                        "searchable": false
                    },
                    {
                        "targets": [ 3 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosCampoCRMSelect?tipo="+tipo+"')!!}",
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

        $('#tcampoSelect tbody')
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
    $('#tcampoSelect tfoot th').each( function () {
        
        var title = $('#tcampoSelect thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        
    } );
 
    // DataTable
    var table = $('#tcampoSelect').DataTable();
 
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

    $('#tcampoSelect tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');

        var datos = table.rows('.selected').data();


    } );
 
     $('#botonCampo').click(function() {
        var datos = table.rows('.selected').data();  

        for (var i = 0; i < datos.length; i++) 
        {   
            var grid = 1;
            var vista = 1;
            var oblig = 1;

            // si no es seleccion para grid
            if(datos[i][2] == 0)
            {    
                grid = 0;
                window.parent.$("#mostrarGridDocumentoCRMCampo"+( window.parent.protCampos.contador - 1)).val(0);
                window.parent.$("#mostrarGridDocumentoCRMCampo"+( window.parent.protCampos.contador - 1)).css('display', 'none');
            }

            // si no es seleccion para obligatoriedad
            if(datos[i][3] == 0)
            {    
                oblig = 0;
                window.parent.$("#obligatorioDocumentoCRMCampo"+( window.parent.protCampos.contador - 1)).val(0);
                window.parent.$("#obligatorioDocumentoCRMCampoC"+( window.parent.protCampos.contador - 1)).css('display', 'none');
            }

            var valores = new Array(0, datos[i][0], datos[i][1], grid, 1, oblig);
            window.parent.protCampos.agregarCampos(valores,'A');
            
            
        }
        window.parent.$("#ModalCampos").modal("hide");
    });

    
});
    
</script>
@stop