function validarconstratista()
{    
    var vacio = '';
    // Si seleccionan el chulito de Contratista debe poner el campo disable 
    if ($('#contratistaTercero').is(":checked"))
    {          
                
         $('#TipoProveedor_idTipoProveedor').prop('disabled', true);           
    } 
    else 
    {
        // Si no seleccionan el chulito de Contratista debe quitar el campo disable
         $('#TipoProveedor_idTipoProveedor').prop('disabled', false);        
    }

// Luego validamos si el usuario dejo alguna opcion seleccionada de ser asi, automaticamente deja el campo vacio
    if ($('#TipoProveedor_idTipoProveedor').val() != 0 || ($('#TipoProveedor_idTipoProveedor').val() != ''))
    {
        $('#TipoProveedor_idTipoProveedor').val(vacio); 
    }

}

function validarFormulario(event)
{
    var route = "http://"+location.host+"/tercero";
    var token = $("#token").val();
    var dato0 = document.getElementById('idTercero').value;
    var dato1 = document.getElementById('documentoTercero').value;
    var dato2 = document.getElementById('nombre1Tercero').value;
    var dato3 = document.getElementById('apellido1Tercero').value;
    var dato4 = document.getElementById('fechaCreacionTercero').value;
    var dato5 = document.getElementById('tipoTercero').value;
    var dato6 = document.getElementById('direccionTercero').value;
    var dato7 = document.getElementById('Ciudad_idCiudad').value;
    var dato8 = document.getElementById('telefonoTercero').value;
    var dato9 = document.getElementById('TipoIdentificacion_idTipoIdentificacion').value;
    var dato10 = document.getElementById('Cargo_idCargo').value;
   
    var valor = '';
    var sw = true;
    
    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idTercero: dato0,
                documentoTercero: dato1,
                nombre1Tercero: dato2,
                apellido1Tercero: dato3,
                fechaCreacionTercero: dato4, 
                tipoTercero: dato5, 
                direccionTercero: dato6, 
                Ciudad_idCiudad: dato7,
                telefonoTercero: dato8,
                TipoIdentificacion_idTipoIdentificacion: dato9                
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            var respuesta = JSON.stringify(msj.responseJSON); 
            if(typeof respuesta === "undefined")
            {
                sw = false;
                $("#msj").html('');
                $("#msj-error").fadeOut();
            }
            else
            {
                sw = true;
                respuesta = JSON.parse(respuesta);

                (typeof msj.responseJSON.documentoTercero === "undefined" ? document.getElementById('documentoTercero').style.borderColor = '' : document.getElementById('documentoTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombre1Tercero === "undefined" ? document.getElementById('nombre1Tercero').style.borderColor = '' : document.getElementById('nombre1Tercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.apellido1Tercero === "undefined" ? document.getElementById('apellido1Tercero').style.borderColor = '' : document.getElementById('apellido1Tercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaCreacionTercero === "undefined" ? document.getElementById('fechaCreacionTercero').style.borderColor = '' : document.getElementById('fechaCreacionTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.tipoTercero === "undefined" ? document.getElementById('tipoTercero').style.borderColor = '' : document.getElementById('tipoTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.direccionTercero === "undefined" ? document.getElementById('direccionTercero').style.borderColor = '' : document.getElementById('direccionTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Ciudad_idCiudad === "undefined" ? document.getElementById('Ciudad_idCiudad').style.borderColor = '' : document.getElementById('Ciudad_idCiudad').style.borderColor = '#a94442');

                (typeof msj.responseJSON.telefonoTercero === "undefined" ? document.getElementById('telefonoTercero').style.borderColor = '' : document.getElementById('telefonoTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.TipoIdentificacion_idTipoIdentificacion === "undefined" ? document.getElementById('TipoIdentificacion_idTipoIdentificacion').style.borderColor = '' : document.getElementById('TipoIdentificacion_idTipoIdentificacion').style.borderColor = '#a94442');

                var mensaje = 'Por favor verifique los siguientes valores <br><ul>';
                $.each(respuesta,function(index, value){
                    mensaje +='<li>' +value+'</li><br>';
                });
                mensaje +='</ul>';
               
                $("#msj").html(mensaje);
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}



// function validarTipoTercero()
// {
//     document.getElementById("tipoTercero").value = '';

//     for (tipo = 1; tipo <= 4; tipo++)
//     {
//         document.getElementById("tipoTercero").value = document.getElementById("tipoTercero").value + ((document.getElementById("tipoTercero" + (tipo)).checked) ? '*' + document.getElementById("tipoTercero" + (tipo)).value + '*' : '');
//     }
//     mostrarPestanas();
// }

// function seleccionarTipoTercero()
// {
//     for (tipo = 1; tipo <= 4; tipo++)
//     {
//         if (document.getElementById("tipoTercero").value.indexOf('*' + document.getElementById("tipoTercero" + (tipo)).value + '*') >= 0)
//         {
//             document.getElementById("tipoTercero" + (tipo)).checked = true;
//         }
//         else
//         {
//             document.getElementById("tipoTercero" + (tipo)).checked = false;
//         }
//     }

//     mostrarPestanas();

// }

function llenaNombreTercero()
{
    nombre1 = document.getElementById('nombre1Tercero').value;
    nombre2 = document.getElementById('nombre2Tercero').value;
    apellido1 = document.getElementById('apellido1Tercero').value;
    apellido2 = document.getElementById('apellido2Tercero').value;

    document.getElementById('nombreCompletoTercero').value = nombre1 + ' ' + nombre2 + ' ' + apellido1 + ' ' + apellido2;
}


// Se utiliza la misma funcion pero se le hacen unos cambios para validar con el id que trae al formulario "TipoTercero ej *01*"
function mostrarPestanas()
{
     // if(document.getElementById('tipoTercero1').checked)
     // *01* Empleados
    if(document.getElementById('tipoTercero').value == '*01*')
    {
        document.getElementById('cargo').style.display = 'inline';
        document.getElementById('zona').style.display = 'none';
        document.getElementById('sector').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'none';
        // Se oculta el fax y pagina  por peticion de vivi
        document.getElementById('fax').style.display = 'none';
        document.getElementById('pagina').style.display = 'none';
        document.getElementById('contenedorproveedor').style.display = 'none';


        
        // document.getElementById('pestanaExamenes').style.display = 'block';
        document.getElementById('pestanaEducacion').style.display = 'block';
        document.getElementById('pestanaExperiencia').style.display = 'block';
        document.getElementById('pestanaFormacion').style.display = 'block';
        document.getElementById('pestanaPersonal').style.display = 'block';
        document.getElementById('pestanaLaboral').style.display = 'block';
        document.getElementById('tipoproveedor').style.display = 'none';
        document.getElementById('pestanaCriterioSeleccion').style.display = 'none';
        document.getElementById('imagentercero').style.display = 'block';
        document.getElementById('nombre1').style.display = 'inline';
        document.getElementById('nombre2').style.display = 'inline';
        document.getElementById('apellido1').style.display = 'inline';
        document.getElementById('apellido2').style.display = 'inline';
        // Se pone  Read Only si es tipo proveedor ya que la funcion llenaNombreTercero concatena  el nombre 
        document.getElementById('nombreCompletoTercero').readOnly = true;
         document.getElementById('checkboxcontratista').style.display = 'none';
    }
    /*else
    {
        document.getElementById('cargo').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'block';   
        document.getElementById('pestanaEducacion').style.display = 'none';
        document.getElementById('pestanaExperiencia').style.display = 'none';
        document.getElementById('pestanaFormacion').style.display = 'none';
        document.getElementById('pestanaPersonal').style.display = 'none';
        document.getElementById('pestanaLaboral').style.display = 'none';
    }*/


    // if(document.getElementById('tipoTercero2').checked)
    // {
    //     document.getElementById('cargo').style.display = 'none';
    //     document.getElementById('zona').style.display = 'inline';
    //     document.getElementById('sector').style.display = 'inline';


    //     document.getElementById('pestanaProducto').style.display = 'block';
    //     // document.getElementById('pestanaExamenes').style.display = 'none';
    //     document.getElementById('pestanaEducacion').style.display = 'none';
    //     document.getElementById('pestanaExperiencia').style.display = 'none';
    //     document.getElementById('pestanaFormacion').style.display = 'none';
    //     document.getElementById('pestanaPersonal').style.display = 'none';
    //     document.getElementById('pestanaLaboral').style.display = 'none';
    //     document.getElementById('tipoproveedor').style.display = 'inline-block';
    //     document.getElementById('pestanaCriterioSeleccion').style.display = 'block';
    // }



    
    // Se pregunta  por el tipo CLiente 
    if(document.getElementById('tipoTercero').value == '*03*')
    {
        document.getElementById('cargo').style.display = 'none';
        document.getElementById('zona').style.display = 'inline';
        document.getElementById('sector').style.display = 'inline';
        // Se oculta el fax y pagina  por peticion de vivi
        document.getElementById('fax').style.display = 'block';
        document.getElementById('pagina').style.display = 'block';
        document.getElementById('contenedorproveedor').style.display = 'none';
        document.getElementById('sexo').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'block';
        // document.getElementById('pestanaExamenes').style.display = 'none';
        document.getElementById('pestanaEducacion').style.display = 'none';
        document.getElementById('pestanaExperiencia').style.display = 'none';
        document.getElementById('pestanaFormacion').style.display = 'none';
        document.getElementById('pestanaPersonal').style.display = 'none';
        document.getElementById('pestanaLaboral').style.display = 'block';
        document.getElementById('tipoproveedor').style.display = 'none';
        document.getElementById('pestanaCriterioSeleccion').style.display = 'none';
        document.getElementById('pestanaobservacion').style.display = 'block';
        document.getElementById('imagentercerooculta').style.display = 'block';
        document.getElementById('nombre1').style.display = 'none';
        document.getElementById('nombre2').style.display = 'none';
        document.getElementById('apellido1').style.display = 'none';
        document.getElementById('apellido2').style.display = 'none';
         document.getElementById('checkboxcontratista').style.display = 'none';
        // Se pone  para que la persona escriba normal  si es tipo CLiente 
        document.getElementById('nombreCompletoTercero').readOnly = false;

    }

     // Proveedor y contratista,Ya que son las mismas opciones
      if(document.getElementById('tipoTercero').value == '*02*' || document.getElementById('tipoTercero').value == '*04*')
    {
        document.getElementById('cargo').style.display = 'none';
        document.getElementById('zona').style.display = 'inline';
        document.getElementById('sector').style.display = 'inline';
        // Se oculta el fax y pagina  por peticion de vivi
        document.getElementById('fax').style.display = 'block';
        document.getElementById('pagina').style.display = 'block';
        document.getElementById('contenedorproveedor').style.display = 'block';
            document.getElementById('tipoproveedor').style.display = 'block';
        document.getElementById('sexo').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'block';
        // document.getElementById('pestanaExamenes').style.display = 'none';
        document.getElementById('pestanaEducacion').style.display = 'none';
        document.getElementById('pestanaExperiencia').style.display = 'none';
        document.getElementById('pestanaFormacion').style.display = 'none';
        document.getElementById('pestanaPersonal').style.display = 'none';
        document.getElementById('pestanaLaboral').style.display = 'block';
        document.getElementById('pestanaCriterioSeleccion').style.display = 'none';
        document.getElementById('pestanaobservacion').style.display = 'block';
        document.getElementById('imagentercerooculta').style.display = 'block';
        document.getElementById('nombre1').style.display = 'none';
        document.getElementById('nombre2').style.display = 'none';
        document.getElementById('apellido1').style.display = 'none';
        document.getElementById('apellido2').style.display = 'none';
        document.getElementById('contratista').style.display = 'block';
        document.getElementById('checkboxcontratista').style.display = 'block';

        
        // Se pone  para que la persona escriba normal  si es tipo CLiente 
        document.getElementById('nombreCompletoTercero').readOnly = false;
    }

    // if(document.getElementById('tipoTercero4').checked)
    // {
    //     document.getElementById('cargo').style.display = 'none';
    //     document.getElementById('zona').style.display = 'inline';
    //     document.getElementById('sector').style.display = 'inline';
    //     document.getElementById('contratista').style.display = 'inline';


    //     document.getElementById('pestanaProducto').style.display = 'block';
    //     // document.getElementById('pestanaExamenes').style.display = 'none';
    //     document.getElementById('pestanaEducacion').style.display = 'none';
    //     document.getElementById('pestanaExperiencia').style.display = 'none';
    //     document.getElementById('pestanaFormacion').style.display = 'none';
    //     document.getElementById('pestanaPersonal').style.display = 'none';
    //     document.getElementById('pestanaLaboral').style.display = 'none';
    //     document.getElementById('tipoproveedor').style.display = 'none';
    //     document.getElementById('pestanaCriterioSeleccion').style.display = 'none';
    // }


    /*else
    {
        document.getElementById('cargo').style.display = 'inline';
        document.getElementById('pestanaProducto').style.display = 'none';
        document.getElementById('pestanaEducacion').style.display = 'block';
        document.getElementById('pestanaExperiencia').style.display = 'block';
        document.getElementById('pestanaFormacion').style.display = 'block';
        document.getElementById('pestanaPersonal').style.display = 'block';
        document.getElementById('pestanaLaboral').style.display = 'block';
    }*/    
}



function abrirModal(file)
{
    // $("#myModal").modal("show");
    if(file != '')
    {
        PreviewImage(file); //Vista previa en tamaño mayor

         $("input[id='archivoTercero']").each(function() 
        {
            $(this).val(file["name"]);
        });
    }
    else
    {
      $("input[id='archivoTercero']").each(function() 
        {
            $(this).val('');
        });
    }           
}

function PreviewImage(archivo) 
{
    pdffile=archivo;
    pdffile_url=URL.createObjectURL(pdffile);
    $('#viewer').attr('src',pdffile_url);
}

function eliminarDiv(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarArchivo").val( $("#eliminarArchivo").val() + idDiv + ",");  
    }
}


function ejecutarInterface(tipo)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/'+tipo,
            type:  'post',
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                if(respuesta[0] == true)
                {
                    
                    alert(respuesta[1]);
                    $("#ModalImportacion").modal("hide");
                    // se agrega un reload para cuando carguen un archivo exitoso se recargue la grid.
                    location.reload();
                }
                else
                {
                    $("#reporteError").html(respuesta[1]);
                    $("#ModalErrores").modal("show");
                }
            },
            error: function(xhr,err)
            { 
                console.log(xhr);
                alert("Error "+xhr);
            }
        });
    $("#dropzoneTerceroArchivo .dz-preview").remove();
    $("#dropzoneTerceroArchivo .dz-message").html('Seleccione o arrastre los archivos a subir.');
}

function mostrarModalInterface()
{
    $("#ModalImportacion").modal("show");
}

function llenarSeleccionProveedor(idTipoProveedor)
{
    var token = document.getElementById('token').value;

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idTipoProveedor': idTipoProveedor},
        url:   'http://'+location.host+'/llenarSeleccionTipoProveedor/',
        type:  'post',
        beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
            },
        success: function(respuesta){
            $("#contenedor_proveedorseleccion").html('');
            
            for (var i = 0; i < respuesta.length; i++) 
            {
                var valores = new Array(respuesta[i]["descripcionTipoProveedorSeleccion"], 0, respuesta[i]["idTipoProveedorSeleccion"], '', '');
                proveedor.agregarCampos(valores,'A'); 
            }  
        },
        error:    function(xhr,err){ 
            alert("Error");
        }
    });
}

function abrirModalFichaTecnica()
{

    idTercero = ($("#Tercero_idTercero").val() == '' ? '' : $("#Tercero_idTercero").val());

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
            var valores = new Array(0, datos[i][2], datos[i][0], datos[i][1]);
            window.parent.productos.agregarCampos(valores,'A');
        }

        window.parent.$("#modalFichaTecnica").modal("hide");
    });
}