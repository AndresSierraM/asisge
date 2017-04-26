function habilitarSubmit(event)
{
    event.preventDefault();
    

    validarformulario();
}

function validarformulario()
{

    var resp = true;


        // Se hace un if para validar por medio del ID si el campo esta vacio para que este se pinte de Rojo 
        // de lo contrario se quedara en blanco y dejara guardar.
        // SI esta vacio este devolvera el campo de color rojo y detendra el formulario 
        if((document.getElementById("TipoInspeccion_idTipoInspeccion").value == '' ))
            {
                // document.getElementById("TipoInspeccion_idTipoInspeccion").style = "background-color:#F5A9A9;";
                //se deja en false para que no envie el formulario hasta que elijan una opcion del select
                resp = false;
            } 
            else
                {
                      // document.getElementById("TipoInspeccion_idTipoInspeccion").style = "background-color:white;";  
                      resp = true;
                } 
        if((document.getElementById("Tercero_idRealizadaPor").value == '' ))
            {
                // document.getElementById("Tercero_idRealizadaPor").style = "background-color:#F5A9A9;";
                //se deja en false para que no envie el formulario hasta que elijan una opcion del select
                resp = false;
            } 
            else
                {
                     resp = true;   
                } 
         if((document.getElementById("fechaElaboracionInspeccion").value == '' ))
            {
                document.getElementById("fechaElaboracionInspeccion").style = "background-color:#F5A9A9;";
                resp = false;
            } 
            else
                {
                     document.getElementById("fechaElaboracionInspeccion").style = "background-color:white;";
                } 

    // Validamos los datos de detalle
    for(actual = 0; actual < inspeccion.contador ; actual++)
    {
        if((document.getElementById("situacionInspeccionDetalle"+(actual)).value == '' ))
        {
            document.getElementById("situacionInspeccionDetalle"+(actual)).style = "vertical-align:top; resize:none; width: 200px; height:60px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("situacionInspeccionDetalle"+(actual)).style = "vertical-align:top; resize:none; width: 200px; height:60px; background-color:white;";
            
        } 
    }
    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique los campos resaltados en rojo, deben ser diligenciados');
    }

    return true;


}

function cargarArchivoInspeccion(registro, idInspeccionDetalle)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idInspeccionDetalle': idInspeccionDetalle},
            url:   'http://'+location.host+'/consultarImagenInspeccion/',
            type:  'post',
            beforeSend: function(){
                },
            success: function(respuesta)
            {
                reg = registro.replace('fotoInspeccionDetalle','');
alert('http://'+location.host+'/imagenes/'+respuesta["fotoInspeccionDetalle"]);
                $('#visualizarInspeccionDetalle'+reg).val('http://'+location.host+'/imagenes/'+respuesta["fotoInspeccionDetalle"]);
            },
            error: function(xhr,err)
            { 
                // alert("Error");
            }
        }); 
}

function visualizarArchivoInspeccion(rutaImagen)
{
    if (rutaImagen != "") 
    {
        window.open(location.host+'/imagenes/'+rutaImagen, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,width=1000,height=1000");
    }
}

function firmarInspeccion(idInspeccion)
{
        var lastIdx = null;
        window.parent.$("#tinspeccionselect").DataTable().ajax.url("http://"+location.host+"/datosInspeccionSelect?idInspeccion="+idInspeccion).load();
         // Abrir modal
        window.parent.$("#modalInspeccion").modal()

        $("a.toggle-vis").on( "click", function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr("data-column") );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        window.parent.$("#tinspeccionselect tbody").on( "mouseover", "td", function () 
        {
            var colIdx = table.cell(this).index().column;

            if ( colIdx !== lastIdx ) {
                $( table.cells().nodes() ).removeClass( "highlight" );
                $( table.column( colIdx ).nodes() ).addClass( "highlight" );
            }
        }).on( "mouseleave", function () {
            $( table.cells().nodes() ).removeClass( "highlight" );
        });


        // Setup - add a text input to each footer cell
        window.parent.$("#tinspeccionselect tfoot th").each( function () 
        {
            var title = window.parent.$("#tinspeccionselect thead th").eq( $(this).index() ).text();
            $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
        });
     
        // DataTable
        var table = window.parent.$("#tinspeccionselect").DataTable();
     
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

        $("#tinspeccionselect tbody").on( "click", "tr", function () 
        {
        if ( $(this).hasClass("selected") ) {
            $(this).removeClass("selected");
        }
        else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }

        var datos = table.rows('.selected').data();

            if (datos.length > 0) 
            {
                $("#idRealizador").val(datos[0][1]);
                signaturePad.clear();
                mostrarFirma();
            }

        });
}

function cerrarDivFirma()
{
    document.getElementById("signature-pad").style.display = "none";
}

function actualizarFirma()
{
    if (signaturePad.isEmpty()) 
    {
        alert("Por Favor Registre Su Firma.");
    } else 
    {
        //window.open(signaturePad.toDataURL());
        reg = '';
        if(document.getElementById("signature-reg").value != 'undefined')
            reg = document.getElementById("signature-reg").value;
        

        document.getElementById("firma"+reg).src = signaturePad.toDataURL() ;
        document.getElementById("firmabase64"+reg).value = signaturePad.toDataURL();
        mostrarFirma();

        var idRealizador = $("#idRealizador").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idRealizador' : idRealizador, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaInspeccion/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}