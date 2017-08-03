@extends('layouts.grid')
@section('titulo')<h3 id="titulo"><center>Matriz de Riesgo por Proceso</center></h3>@stop
@section('content')

{!!Html::script('js/matrizriesgo.js'); !!}

{!!Html::script('js/dropzone.js'); !!}<!--Llamo al dropzone-->
{!!Html::style('assets/dropzone/dist/min/dropzone.min.css'); !!}<!--Llamo al dropzone-->
{!!Html::style('css/dropzone.css'); !!}<!--Llamo al dropzone-->

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
                        <input type="hidden" id="token" value="{{csrf_token()}}"/>
                        <button type="button" class="btn btn-default dropdown-toggle"data-toggle="dropdown">
                            <i class="glyphicon glyphicon-th icon-th"></i> 
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li><a class="toggle-vis" data-column="0"><label> Iconos</label></a></li>
                            <li><a class="toggle-vis" data-column="1"><label> ID</label></a></li>
                            <li><a class="toggle-vis" data-column="2"><label> Fecha</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Responsable</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Procesos</label></a></li>
                        </ul>
                    </div>
                    <table id="matrizriesgoproceso" name="matrizriesgoproceso" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:55px;padding: 1px 8px;" data-orderable="false">
                                 <a href="matrizriesgoproceso/create"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-plus"></span></a>
                                <!--  <a href="javascript:mostrarModalInterface();"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-cloud-upload"></span></a> -->
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>Fecha</b></th>
                                <th><b>Responsable</b></th>
                                <th><b>Procesos</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:55px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Responsable</th>
                                <th>Procesos</th>
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
        window.open('matrizriesgoproceso/'+id+'?accion=imprimir','matrizriesgoproceso','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
    }

    // function mostrarModalInterface()
    // {
    //     $("#modalMatrizRiesgo").modal();
    // }

    $(document).ready( function () {

        
        /*$('#matrizriesgoproceso').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosMatrizRiesgo')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        var imprimir = '<?php echo $dato["consultarRolOpcion"];?>';
        var table = $('#matrizriesgoproceso').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosMatrizRiesgoProceso?modificar="+modificar+"&eliminar="+eliminar+"&imprimir="+imprimir+"')!!}",
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

        $('#matrizriesgoproceso tbody')
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
    $('#matrizriesgoproceso tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#matrizriesgoproceso thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#matrizriesgoproceso').DataTable();
 
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

<script type="text/javascript">
        
        
    //--------------------------------- DROPZONE ---------------------------------------
    var baseUrl = "{{ url("/") }}";
    var token = "{{ Session::getToken() }}";
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#dropzoneMatrizRiesgoArchivo", {
        url: baseUrl + "/dropzone/uploadFiles",
        params: {
            _token: token
        },
        
    });

     fileList = Array();
    var i = 0;

    //Configuro el dropzone
    myDropzone.options.myAwesomeDropzone =  {
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 40, // MB
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    addRemoveLinks: true,
    clickable: true,
    previewsContainer: ".dropzone-previews",
    clickable: false,
    uploadMultiple: true,
    accept: function(file, done) {

      }
    };

    //envio las funciones a realizar cuando se de clic en la vista previa dentro del dropzone
     myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function(reg) {
          });
        });

    document.getElementById('archivoMatrizRiesgoArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
                        // console.log(fileList);

                        document.getElementById('archivoMatrizRiesgoArray').value += file.name+',';
                        console.log(document.getElementById('archivoMatrizRiesgoArray').value);
                        i++;
                    });


</script>
@stop

<div id="modalMatrizRiesgo" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;"">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Arrastre los archivos a importar</h4>
      </div>
      <div class="modal-body">
       <div class="container"  style="height:400px;">
            <div class="row">
                <div class="container">
                
                    <div id="upload" class="col-md-9">
                        <div class="input-group col-lg-12 col-md-12" >  
                           <div class="form-group">
                                <div class="input-group col-lg-12 col-md-12">
                                    <div class="dropzone dropzone-previews" id="dropzoneMatrizRiesgoArchivo"  style="height:330px;" ></div>  
                                    {!!Form::hidden('archivoMatrizRiesgoArray', '', array('id' => 'archivoMatrizRiesgoArray'))!!}
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

      </div>
       <div class="modal-footer">
        
            <button type="button" class="btn btn-success"  onclick="ejecutarInterface();" >Ejecutar</button>
            <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>

      </div>
    </div>
  </div>
</div>

<div id="ModalErroresMatrizRiesgo" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;"">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Reporte de Inconsistencias en la Importación</h4>
      </div>
      <div class="modal-body">
       <div class="container col-md-12"  style="height:400px;">
            <div class="row">
                <div id="reporteErrorMatrizRiesgo" class="container col-md-12">
                
                    
                </div>
            </div>
        </div>

      </div>
       <div class="modal-footer">
        
            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>

      </div>
    </div>
  </div>
</div>