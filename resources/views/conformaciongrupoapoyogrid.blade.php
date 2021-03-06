@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Conformaci&oacute;n <br>Grupos de Apoyo</center></h3>@stop
@section('content')
{!!Html::script('js/conformaciongrupoapoyo.js')!!}
{!!Html::style('css/signature-pad.css'); !!}
{!!Html::style('css/cerrardiv.css'); !!} 
<style>
    tfoot input {
                width: 100%;
                padding: 3px;
                background-color: #fff;
                background-image: none;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            .m-signature-pad
            {
              position: absolute;
              font-size: 10px;
              width: 100%;
              height: 100%;
              top: -17%;
              left: -3%;
              margin-left: 0px;
              margin-top: 0px;
              border: 1px solid #e8e8e8;
              background-color: #fff;
              box-shadow: 0 1px 4px rgba(0, 0, 0, 0.27), 0 0 40px rgba(0, 0, 0, 0.08) inset;
              border-radius: 4px;
              z-index: 99;
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
    <input type="hidden" id="token" value="{{csrf_token()}}"/>
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
                            <li><a class="toggle-vis" data-column="2"><label> Grupo de Apoyo</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Nombre</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Fecha</label></a></li>
                        </ul>
                    </div>
                    <table id="tconformaciongrupoapoyo" name="tconformaciongrupoapoyo" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:70px;padding: 1px 8px;" data-orderable="false">
                                 <a href="conformaciongrupoapoyo/create"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-plus"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>Grupo de Apoyo</b></th>
                                <th><b>Nombre</b></th>
                                <th><b>Fecha</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>Grupo de Apoyo</th>
                                <th>Nombre</th>
                                <th>Fecha</th>
                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>

{!!Form::button('Limpiar filtros',["class"=>"btn btn-primary","id"=>'btnLimpiarFiltros'])!!}
<script type="text/javascript">
function imprimirConformacionGrupoApoyo(id)
    {
        window.open('conformaciongrupoapoyo/'+id+'?accion=imprimir','Formato','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
    }
    $(document).ready( function () {
        mostrarFirma();
        
        /*$('#tconformaciongrupoapoyo').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosConformacionGrupoApoyo')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var imprimir = '<?php echo (isset($datos[0]) ? $dato["consultarRolOpcion"] : 0);?>';
        var table = $('#tconformaciongrupoapoyo').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosConformacionGrupoApoyo?modificar="+modificar+"&eliminar="+eliminar+"&imprimir="+imprimir+"')!!}",
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

        $('#tconformaciongrupoapoyo tbody')
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
    $('#tconformaciongrupoapoyo tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#tconformaciongrupoapoyo thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#tconformaciongrupoapoyo').DataTable();
 
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
{!!Html::script('js/signature_pad.js'); !!}
{!!Html::script('js/app1.js'); !!}
@stop

<div id="modalConformacionGrupoApoyo" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:100%;">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Jurados</h4>
      </div>
      <div class="modal-body">

        <div id="signature-pad" class="m-signature-pad">
        <a class='cerrar' href='javascript:void(0);' onclick='cerrarDivFirma(); document.getElementById(&apos;signature-pad&apos;).style.display = &apos;none&apos;'>x</a> 
            <input type="hidden" id="signature-reg" value="">
            <div class="m-signature-pad--body">
              <canvas></canvas>
            </div>
            <div class="m-signature-pad--footer">
              <div class="description">Firme sobre el recuadro</div>
              <button type="button" class="button clear btn btn-danger" data-action="clear">Limpiar</button>
              <button type="button" class="button save btn btn-success"  onclick="actualizarFirma()">Guardar Firma</button>
                <img id="firma" style="width:200px; height: 150px; border: 1px solid; display:none;"  src="">
                {!!Form::hidden('firmabase64', null, array('id' => 'firmabase64'))!!}
                {!!Form::hidden('idGrupoApoyo', null, array('id' => 'idGrupoApoyo'))!!}
                {!!Form::hidden('idJurado', null, array('id' => 'idJurado'))!!}
            </div>
        </div>

         <div class="container">
            <div class="row">
                <div class="container col-md-9 col-sm-12">
                    <div class="btn-group" style="margin-left: 94%;margin-bottom:4px" title="Columns">
                        <button  type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                       <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> Nombre</label></a></li>
                        </ul>
                    </div>
                    
                    <table id="tconformaciongrupoapoyoselec" name="tconformaciongrupoapoyoselec" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th><b>Nombre</b></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="btn-default active">
                                <th>Nombre</th>
                            </tr>
                        </tfoot>
                    </table>                
                </div>
            </div>
        </div>
      </div>
       <div class="modal-footer">
            <button type="button" class="btn btn-danger"  data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
