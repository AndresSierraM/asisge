function arirModalMovimiento(idDocumento, idTercero)
{
    var lastIdx = null;
    window.parent.$("#tmovimiento").DataTable().ajax.url("http://"+location.host+"/datosPerfilClienteMovimiento?idDocumento="+idDocumento+"&idTercero="+idTercero).load();
     // Abrir modal
    window.parent.$("#modalMovimiento").modal()

    $("a.toggle-vis").on( "click", function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr("data-column") );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    window.parent.$("#tmovimiento tbody").on( "mouseover", "td", function () 
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
    window.parent.$("#tmovimiento tfoot th").each( function () 
    {
        var title = window.parent.$("#tmovimiento thead th").eq( $(this).index() ).text();
        $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
    });
 
    // DataTable
    var table = window.parent.$("#tmovimiento").DataTable();
 
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

function consultarEdadTercero()
{
    fecha = $("#fechaNacimientoTercero").val();

    var values=fecha.split("-");

    var dia = values[2];

    var mes = values[1];

    var ano = values[0];

    // cogemos los valores actuales

    var fecha_hoy = new Date();

    var ahora_ano = fecha_hoy.getYear();

    var ahora_mes = fecha_hoy.getMonth()+1;

    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo

    var edad = (ahora_ano + 1900) - ano;

    if ( ahora_mes < mes )

    {
        edad--;
    }

    if ((mes == ahora_mes) && (ahora_dia < dia))
    {
        edad--;
    }

    if (edad > 1900)
    {
        edad -= 1900;
    }

    $("#edadTercero").val(edad);
}
    // window.parent.$("#tmovimiento tbody").on( "dblclick", "tr", function () 
    // {
    //     if ( $(this).hasClass("selected") ) {
    //         $(this).removeClass("selected");
    //     }
    //     else {
    //         table.$("tr.selected").removeClass("selected");
    //         $(this).addClass("selected");
    //     }

    //     var datos = table.rows('.selected').data();
    //     console.log(datos);

    //         if (datos.length > 0) 
    //         {
    //             enviarDatosLista(datos[0][0], datos[0][1], datos[0][2], datos[0][3], datos[0][4]);
    //         }

    //     window.parent.$("#ListaSelect").modal("hide");

    // } );

}