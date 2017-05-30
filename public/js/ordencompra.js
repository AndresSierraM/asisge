function abrirModalCRM()
{
    idDocumentoCRM = $("#DocumentoCRM_idDocumentoCRM").val()

    window.parent.$("#tmovimientocrm tbody tr").each( function () 
    {
        $(this).removeClass('selected');
    });

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

        $("#requerimientoOrdenCompra").val(requerimiento.substring(0,requerimiento.length-2));

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
                var valores = new Array(respuesta[i]['idFichaTecnica'], respuesta[i]['referenciaFichaTecnica'], respuesta[i]['nombreFichaTecnica'], '1', '1', '1', 0, respuesta[i]['MovimientoCRM_idMovimientoCRM']);
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
        total += parseFloat($("#valorTotalOrdenCompraProducto"+i, window.parent.document).val());
    }
            
    $('#totalProducto', window.parent.document).val(total);
}