
function cambiarEstado(idDocumentoCRM, estado, modificar, eliminar, consultar, aprobar)
{
    location.href= 'http://'+location.host+"/ordencompra?idDocumentoCRM="+idDocumentoCRM+"&estado="+estado+"&modificar="+modificar+"&eliminar="+eliminar+"&consultar="+consultar+"&aprobar="+aprobar;
}

function abrirModalCRM()
{
    idDocumentoCRM = $("#DocumentoCRM_idDocumentoCRM").val()

    window.parent.$("#tmovimientocrm tbody tr").each( function () 
    {
        $(this).removeClass('selected');
    });

    $("#divTabla").html('');

    estructuraTabla = '<div class="row" style="width:90%;">'+
                        '<div class="container" style="width:100%;">'+
                            '<table id="tmovimientocrm" name="tmovimientocrm" class="display table-bordered" width="100%">'+
                              '<thead>'+
                                  '<tr class="btn-default active">'+
                                      '<th><b>ID</b></th>'+
                                      '<th><b>Descripción</b></th> '+       
                                  '</tr>'+
                              '</thead>'+
                              '<tfoot>'+
                                  '<tr class="btn-default active">'+

                                      '<th>ID</th>'+
                                      '<th>Descripción</th> '+                            
                                  '</tr>'+
                              '</tfoot>'+
                          '</table>'+
                          '<div class="modal-footer">'+
                                '<button id="botonMovimientoCRM" name="botonMovimientoCRM" type="button" class="btn btn-primary" >Seleccionar</button>'+
                            '</div>'+
                        '</div>'+
                     '</div>';

    $("#divTabla").html(estructuraTabla);

    var lastIdx = null;
    window.parent.$("#tmovimientocrm").DataTable().ajax.url('http://'+location.host+"/datosMovimientoCRMModal?idDocumentoCRM="+idDocumentoCRM).load();
     // Abrir modal
    window.parent.$("#modalMovimientoCRM").modal();

    $("a.toggle-vis").on( "click", function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr("data-column") );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    window.parent.$("#tmovimientocrm tbody").on( "mouseover", "td", function () 
    {
        var colIdx = table.cell(this).index().column;

        if ( colIdx !== lastIdx ) {
            $( table.cells().nodes() ).removeClass( "highlight" );
            $( table.column( colIdx ).nodes() ).addClass( "highlight" );
        }
    }).on( "mouseleave", function () 
    {
        $( table.cells().nodes() ).removeClass( "highlight" );
    } );


    // Setup - add a text input to each footer cell
    window.parent.$("#tmovimientocrm tfoot th").each( function () 
    {
        var title = window.parent.$("#tmovimientocrm thead th").eq( $(this).index() ).text();
        $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
    });
 
    // DataTable
    var table = window.parent.$("#tmovimientocrm").DataTable();
 
    // Apply the search
    table.columns().every( function () 
    {
        var that = this;
 
        $( "input", this.footer() ).on( "blur change", function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    })

    $('#tmovimientocrm tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    $('#botonMovimientoCRM').click(function() {

        var datos = table.rows('.selected').data();

        var requerimiento = "";
        for (var i = 0; i < datos.length; i++) 
        {
            requerimiento += datos[i][1]+', ';

            cargarProductos(datos[i][0]);
        };

        if ($("#requerimientoOrdenCompra").val() == '') 
            $("#requerimientoOrdenCompra").val(requerimiento.substring(0,requerimiento.length-2));
        else
            $("#requerimientoOrdenCompra").val($("#requerimientoOrdenCompra").val()+', '+requerimiento.substring(0,requerimiento.length-2));

        window.parent.$("#modalMovimientoCRM").modal("hide");
    });
}

function cargarProductos(idMovimientoCRM)
{
    var token = document.getElementById('token').value;

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idMovimientoCRM': idMovimientoCRM},
        url:   'http://'+location.host+'/cargarProductosOrdenCompra/',
        type:  'post',
        beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
            },
        success: function(respuesta){
            for (var i = 0; i < respuesta.length; i++) 
            {
                var valores = new Array(respuesta[i]['idFichaTecnica'], respuesta[i]['referenciaFichaTecnica'], respuesta[i]['nombreFichaTecnica'], respuesta[i]['cantidadMovimientoCRMProducto'], respuesta[i]['valorUnitarioMovimientoCRMProducto'], respuesta[i]['valorTotalMovimientoCRMProducto'], 0, respuesta[i]['MovimientoCRM_idMovimientoCRM']);
                window.parent.producto.agregarCampos(valores,'A');
            }
            calcularTotales();
        },
        error:    function(xhr,err){ 
            alert("Error");
        }
    });
}

function abrirModalFichaTecnica()
{
    window.parent.$("#tfichatecnica tbody tr").each( function () 
    {
        $(this).removeClass('selected');
    });
    
    $("#divTablaFichaTecnica").html('');

    estructuraTabla = '<table id="tfichatecnica" name="tfichatecnica" class="display table-bordered" width="100%">'+
                          '<thead>'+
                              '<tr class="btn-default active">'+
                                  '<th><b>Referencia</b></th>'+
                                  '<th><b>Descripción</b></th> '+       
                              '</tr>'+
                          '</thead>'+
                          '<tfoot>'+
                              '<tr class="btn-default active">'+

                                  '<th>Referencia</th>'+
                                  '<th>Descripción</th> '+                            
                              '</tr>'+
                          '</tfoot>'+
                      '</table>'+
                      '<div class="modal-footer">'+
                        '<button id="botonFichaTecnica" name="botonFichaTecnica" type="button" class="btn btn-primary" >Seleccionar</button>'+
                    '</div>';

    $("#divTablaFichaTecnica").html(estructuraTabla);

    var lastIdx = null;
    window.parent.$("#tfichatecnica").DataTable().ajax.url('http://'+location.host+"/datosFichaTecnicaModal?ficha=tercero").load();
     // Abrir modal
    window.parent.$("#modalFichaTecnica").modal()

    $("a.toggle-vis").on( "click", function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr("data-column") );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    window.parent.$("#tfichatecnica tbody").on( "mouseover", "td", function () 
    {
        var colIdx = table.cell(this).index().column;

        if ( colIdx !== lastIdx ) {
            $( table.cells().nodes() ).removeClass( "highlight" );
            $( table.column( colIdx ).nodes() ).addClass( "highlight" );
        }
    }).on( "mouseleave", function () 
    {
        $( table.cells().nodes() ).removeClass( "highlight" );
    } );


    // Setup - add a text input to each footer cell
    window.parent.$("#tfichatecnica tfoot th").each( function () 
    {
        var title = window.parent.$("#tfichatecnica thead th").eq( $(this).index() ).text();
        $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
    });
 
    // DataTable
    var table = window.parent.$("#tfichatecnica").DataTable();
 
    // Apply the search
    table.columns().every( function () 
    {
        var that = this;
 
        $( "input", this.footer() ).on( "blur change", function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    })

    $('#tfichatecnica tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    $('#botonFichaTecnica').click(function() {
        var datos = table.rows('.selected').data();

        for (var i = 0; i < datos.length; i++) 
        {
            var valores = new Array(datos[i][2], datos[i][0], datos[i][1], '1', '1', '1', 0, '');
            window.parent.producto.agregarCampos(valores,'A');
        }

        calcularTotales();

        window.parent.$("#modalFichaTecnica").modal("hide");
    });
}

function calcularValorTotal(registro, tipo)
{
    reg = registro;
    if (tipo == 'cantidad') 
    {
        reg = registro.replace('cantidadOrdenCompraProducto','');
    }
    else if(tipo == 'unitario')
    {
        reg = registro.replace('valorUnitarioOrdenCompraProducto','');   
    }

    valor = parseFloat($("#cantidadOrdenCompraProducto"+reg).val()) * parseFloat($("#valorUnitarioOrdenCompraProducto"+reg).val());

    $("#valorTotalOrdenCompraProducto"+reg).val(valor)

    calcularTotales();
    
}

function calcularTotales()
{
    total = 0;

    for (var i = 0; i < window.parent.producto.contador; i++) 
    {
        if(typeof $("#valorTotalOrdenCompraProducto"+i, window.parent.document).val() != 'undefined' &&
            $("#valorTotalOrdenCompraProducto"+i, window.parent.document).val() > 0)
        {
            total += parseFloat($("#valorTotalOrdenCompraProducto"+i, window.parent.document).val());
        }
    }
            
    $('#totalProducto', window.parent.document).val(total);
}

function mostrarModalAutorizador(idOrdenCompra)
{
    $("#idOrden").val(idOrdenCompra);
    $("#modalAutorizador").modal("show");
}

function autorizarOrdenCompra()
{
    idOrdenCompra = $("#idOrden").val();
    Tercero_idAutorizador = $("#Autorizador").val();
    fechaAprobacionOrdenCompra = $("#fechaAprobacion").val();
    estadoOrdenCompra = $("#estadoOrden").val();
    observacionAprobacionOrdenCompra = $("#observacionOrden").val();

    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/autorizarOrdenCompra',
            type:  'post',
            data: {idOrdenCompra : idOrdenCompra,
                    Tercero_idAutorizador: Tercero_idAutorizador,
                    fechaAprobacionOrdenCompra: fechaAprobacionOrdenCompra,
                    estadoOrdenCompra: estadoOrdenCompra,
                    observacionAprobacionOrdenCompra: observacionAprobacionOrdenCompra},
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                alert(respuesta[1]);
                $("#modalAutorizador").modal("hide");
                location.reload();
            },
            error: function(xhr,err)
            { 
                console.log(xhr);
                alert("Error "+xhr);
            }
        });
}

function imprimirFormato(idOrdenCompra, idDocumentoCRM)
{
    window.open('ordencompra/'+idOrdenCompra+'?idDocumentoCRM='+idDocumentoCRM+'&accion=imprimir','ordencompra','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}