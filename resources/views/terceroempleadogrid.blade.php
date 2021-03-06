@extends('layouts.grid')
<!-- El tipo tercero ya no se va a utilizar ya que vamos a usar 3 grid para cada tipo de empleado con su propio ajax y se van a quemar lo tipos -->
<!-- 
<?php 
$tipoTercero = $_GET['tipoTercero'];

// Se crea una  variable para hacer el titulo de grid dinamico Dependiendo el tipo de tercero
$titulo = ($tipoTercero == '*01*' ? 'Tercero Tipo Empleado' : ($tipoTercero == '*02*' ? 'Proveedor/Contratistas' : ($tipoTercero == '*03*' ? 'Tercero Tipo Cliente' : 'Proveedor/Contratistas')));
?> -->
@section('titulo')<h3 id="titulo"><center> Tercero Tipo Empleado</center></h3>@stop
@section('content')

{!!Html::script('js/tercero.js'); !!}

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


    #imagenTercero 
    {
      width: 700px;
      height: 200px;
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
                            <li><a class="toggle-vis" data-column="2"><label> Identificación</label></a></li>
                            <li><a class="toggle-vis" data-column="3"><label> Número Documento</label></a></li>
                            <li><a class="toggle-vis" data-column="4"><label> Nombre</label></a></li>
                            <li><a class="toggle-vis" data-column="5"><label> Estado</label></a></li>
                            <li><a class="toggle-vis" data-column="6"><label> Cargo</label></a></li>
                            <li><a class="toggle-vis" data-column="7"><label> Fecha Ingreso</label></a></li>
                            <li><a class="toggle-vis" data-column="8"><label> Centro de Costos</label></a></li>
                        </ul>
                    </div>
                    <table id="ttercero" name="ttercero" class="display table-bordered" width="100%">
                        <thead>
                            <tr class="btn-default active">
                                <th style="width:60px;padding: 1px 8px;" data-orderable="false">
                                 <?php echo '<a href="tercero/create?tipoTercero='.'*01*'.'"><span style= "display:'.$visible.'" class="glyphicon glyphicon-plus"></span></a>'; ?>
                                 <a href="javascript:mostrarModalInterface();"><span style= "display: <?php echo $visible;?> " class="glyphicon glyphicon-cloud-upload"></span></a>
                                 <a href="#"><span class="glyphicon glyphicon-refresh"></span></a>
                                </th>
                                <th><b>ID</b></th>
                                <th><b>Identificación</b></th>
                                <th><b>Número Documento</b></th>
                                <th><b>Nombre</b></th>
                                <th><b>Estado</b></th>
                                <th><b>Cargo</b></th>
                                <th><b>Fecha Ingreso</b></th>
                                <th><b>Centro de Costos</b></th>
                            </tr>
                        </thead>
                                        <tfoot>
                            <tr class="btn-default active">
                                <th style="width:40px;padding: 1px 8px;">
                                    &nbsp;
                                </th>
                                <th>ID</th>
                                <th>Identificación</th>
                                <th>Número Documento</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Cargo</th>
                                <th>Fecha Ingreso</th>
                                <th>Centro de Costos</th>

                            </tr>
                        </tfoot>        
                    </table>
                </div>
            </div>
        </div>






{!!Form::button('Limpiar filtros',["class"=>"btn btn-primary","id"=>'btnLimpiarFiltros'])!!}
<script type="text/javascript">

    $(document).ready( function () {

        
        /*$('#ttercero').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosTercero')!!}",
        });*/
        var lastIdx = null;
        var modificar = '<?php echo (isset($datos[0]) ? $dato["modificarRolOpcion"] : 0);?>';
        var eliminar = '<?php echo (isset($datos[0]) ? $dato["eliminarRolOpcion"] : 0);?>';
        // En el document ready de la grid se pregunta por el tipo para añadirlo a la url
        // Ya no se pregunta por el tipo de tercero si no que se quema la opcion, ya que cada tipo de tercero va a tener su propia grid y ajax
        // var tipo = '<?php echo $tipoTercero?>';
        // Se crea una variable que contenga el tipo quemado 01 que es EMPLEADO
        var tipoEmpleado = '*01*';
        var table = $('#ttercero').DataTable( {
            "order": [[ 1, "asc" ]],
            "aProcessing": true,
            "aServerSide": true,
            "stateSave":true,
            "ajax": "{!! URL::to ('/datosTerceroEmpleado?modificar="+modificar+"&eliminar="+eliminar+"&tipoTercero="+tipoEmpleado+"')!!}",
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

        $('#ttercero tbody')
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
    $('#ttercero tfoot th').each( function () {
        if($(this).index()>0){
        var title = $('#ttercero thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Buscar por '+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#ttercero').DataTable();
 
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
    var myDropzone = new Dropzone("div#dropzoneTerceroArchivo", {
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
            // abrirModal(file);
            // pos = fileList.indexOf(file["name"]);
            // alert(pos);
            // console.log(fileList[pos]);
            // $("#tituloTerceroArchivo").val(fileList[pos]["titulo"]);
          });
        });

    document.getElementById('archivoTerceroArray').value = '';
    myDropzone.on("success", function(file, serverFileName) {
                        abrirModal(file);
                        fileList[i] = {"serverFileName" : serverFileName, "fileName" : file.name,"fileId" : i, "titulo" : '' };
                        // console.log(fileList);

                        document.getElementById('archivoTerceroArray').value += file.name+',';
                        // console.log(document.getElementById('archivoTerceroArray').value);
                        i++;
                    });


</script>


@stop


<div id="ModalImportacion" class="modal fade" role="dialog">
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
                                    <div class="dropzone dropzone-previews" id="dropzoneTerceroArchivo"  style="height:330px;" ></div>  
                                    {!!Form::hidden('archivoTercero', 0, array('id' => 'archivoTercero'))!!}
                                    {!!Form::hidden('archivoTerceroArray', '', array('id' => 'archivoTerceroArray'))!!}
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>

      </div>
       <div class="modal-footer">
        
            <button type="button"   onclick="ejecutarInterface('importarTerceroProveedor');" >Importar Proveedores</button>
            <button type="button"   onclick="ejecutarInterface('importarTerceroEmpleado');" >Importar Empleados</button>
            <button type="button"  data-dismiss="modal">Cancelar</button>

      </div>
    </div>
  </div>
</div>


<div id="ModalErrores" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:70%;"">

    <!-- Modal content-->
    <div style="" class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Reporte de Inconsistencias en la Importación</h4>
      </div>
      <div class="modal-body">
       <div class="container col-md-12"  style="height:400px;">
            <div class="row">
                <div id="reporteError" class="container col-md-12">
                
                    
                </div>
            </div>
        </div>

      </div>
       <div class="modal-footer">
        
            <button type="button"  data-dismiss="modal">Aceptar</button>

      </div>
    </div>
  </div>
</div>