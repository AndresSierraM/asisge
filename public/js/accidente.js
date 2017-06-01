// Se hace una funcion para que elimine los archivos que estan subidos en el dropzone y estan siendo mostrados en la preview
function eliminarDiv(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarArchivo").val( $("#eliminarArchivo").val() + idDiv + ",");  
    }
}


function buscarAusentismo(){

	var idEmpleado = document.getElementById('Tercero_idEmpleado').value;
	var token = document.getElementById('token').value;

	$.ajax({
		headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idEmpleado' : idEmpleado},
            url:   'http://'+location.host+'/llenarAusentismo/',
            type:  'post',
		success: function(data){
            
            var select = document.getElementById('Ausentismo_idAusentismo');
            
            select.options.length = 0;
            var option = '';

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione la Ausencia...';
            select.appendChild(option);

            for(var j=0,k=data.length;j<k;j++)
            {
				option = document.createElement('option');
                option.value = data[j].idAusentismo;
                option.text = data[j].nombreAusentismo;
                option.selected = (document.getElementById("Ausentismo_idAusentismo").value == data[j].idAusentismo ? true : false);
                select.appendChild(option);

            }

        }
	});
}

function consultarFecha(idTercero)
{

    var token = document.getElementById('token').value;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idTercero': idTercero},
                url:   'http://'+location.host+'/consultarFechaEmpleadoAccidente/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    fecha = respuesta['fechaNacimientoTerceroInformacion'];
                    
                if (fecha !== '0000-00-00') 
                {

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

                    $("#edadEmpleadoAccidente").val(edad);
                }
                else
                {
                    alert("Debe llenar la fecha de nacimiento del empleado en el modulo de tercero.");
                    $("#edadEmpleadoAccidente").val('');
                }

                fechaant = respuesta['fechaIngresoTerceroInformacion'];
                if (fechaant !== '0000-00-00') 
                {                    
                    var values=fechaant.split("-");

                    var dia = values[2];

                    var mes = values[1];

                    var ano = values[0];

                    // cogemos los valores actuales

                    var fecha_hoy = new Date();

                    var ahora_ano = fecha_hoy.getYear();

                    var ahora_mes = fecha_hoy.getMonth()+1;

                    var ahora_dia = fecha_hoy.getDate();

                    // realizamos el calculo

                    var tiemposerv = (ahora_ano + 1900) - ano;

                    if ( ahora_mes < mes )

                    {
                        tiemposerv--;
                    }

                    if ((mes == ahora_mes) && (ahora_dia < dia))
                    {
                        tiemposerv--;
                    }

                    if (tiemposerv > 1900)
                    {
                        tiemposerv -= 1900;
                    }

                    // calculamos los meses

                    var meses=0;

                    if(ahora_mes>mes)

                        meses=ahora_mes-mes;

                    if(ahora_mes<mes)

                        meses=12-(mes-ahora_mes);

                    if(ahora_mes==mes && dia>ahora_dia)

                        meses=11;

                    $("#tiempoServicioAccidente").val(tiemposerv+' AÑOS '+meses+' MESES');
                }
                else
                {
                    alert("Debe llenar el tiempo de servicio del empleado en el modulo de tercero.");
                    $("#tiempoServicioAccidente").val('');   
                }

            },
            error: function(xhr,err)
            { 
                alert("Debe llenar la fecha de nacimiento o el tiempo de servicio del empleado en el modulo de tercero.");
                $("#tiempoServicioAccidente").val('');
                $("#edadEmpleadoAccidente").val('');
            }   
        });
}

function validarFormulario(event)
{
    var route = "http://"+location.host+"/accidente";
    var token = $("#token").val();
    var dato0 = document.getElementById('idAccidente').value;
    var dato1 = document.getElementById('Tercero_idCoordinador').value;
    var dato2 = document.getElementById('nombreAccidente').value;
    var dato3 = document.getElementById('fechaOcurrenciaAccidente').value;
    var dato4 = document.getElementById('clasificacionAccidente').value;
    var dato5 = document.getElementById('Tercero_idEmpleado').value;
    var dato6 = document.getElementById('Ausentismo_idAusentismo').value;
    var dato7 = document.getElementById('Proceso_idProceso').value;

    // Estos dos de abajo son campos de la multiregistro
    // Primero se asigna a una variable y por cada registro que vayas a validar crea un nuevo dato-tal
    // Siguiendo el mismo orden en que venias, 7, 8, 9 ...
    var datoResponsable = document.querySelectorAll("[name='Proceso_idResponsable[]']");
    var datoInvestigador = document.querySelectorAll("[name='Tercero_idInvestigador[]']"); 
    var dato8 = [];
    var dato9 = [];
    
    var valor = '';
    var sw = true;
    
    // Luego, dependiendo del numero de campos que vaya a validar en la multi, haces los for, si son 3 campos, son 3 for, en este caso son 2
    // el for es con la variable en la que asignó el campo y luego le asigna el dato-tal a esa variable
    for(var j=0,i=datoResponsable.length; j<i;j++)
    {
        dato8[j] = datoResponsable[j].value;
    }

    for(var j=0,i=datoInvestigador.length; j<i;j++)
    {
        dato9[j] = datoInvestigador[j].value;
    }

    // En este punto ya empieza el ajax normal, simplemente reemplazando valores o bueno, asignando los valores en el data, los mismos que tiene arriba

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idAccidente: dato0,
                Tercero_idCoordinador: dato1,
                nombreAccidente: dato2,
                fechaOcurrenciaAccidente: dato3,
                clasificacionAccidente: dato4, 
                Tercero_idEmpleado: dato5, 
                Ausentismo_idAusentismo: dato6, 
                Proceso_idProceso: dato7,
                Proceso_idResponsable: dato8,
                Tercero_idInvestigador: dato9,
                // solo se modifica los campos del data
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

                (typeof msj.responseJSON.Tercero_idCoordinador === "undefined" ? document.getElementById('Tercero_idCoordinador').style.borderColor = '' : document.getElementById('Tercero_idCoordinador').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreAccidente === "undefined" ? document.getElementById('nombreAccidente').style.borderColor = '' : document.getElementById('nombreAccidente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaOcurrenciaAccidente === "undefined" ? document.getElementById('fechaOcurrenciaAccidente').style.borderColor = '' : document.getElementById('fechaOcurrenciaAccidente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.clasificacionAccidente === "undefined" ? document.getElementById('clasificacionAccidente').style.borderColor = '' : document.getElementById('clasificacionAccidente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idEmpleado === "undefined" ? document.getElementById('Tercero_idEmpleado').style.borderColor = '' : document.getElementById('Tercero_idEmpleado').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Ausentismo_idAusentismo === "undefined" ? document.getElementById('Ausentismo_idAusentismo').style.borderColor = '' : document.getElementById('Ausentismo_idAusentismo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Proceso_idProceso === "undefined" ? document.getElementById('Proceso_idProceso').style.borderColor = '' : document.getElementById('Proceso_idProceso').style.borderColor = '#a94442');
                // todos essos son los campos de encabezado, aca solo debe cambiar esto (todos los campos menos el id)
                // a cada registro le pone un campo de los que hay en el data que sea de encabezado

    //             1) el id se llene o no, siempre va a crearse porque es autonumerico
    // 2)como es un campo hidden, esta porcion lo unico que hace es pintae rojo el campo que no se llenó ypues como se va a pintar un campo que esta oculto

                for(var j=0,i=datoResponsable.length; j<i;j++)
                {
                    (typeof respuesta['Proceso_idResponsable'+j] === "undefined" 
                        ? document.getElementById('Proceso_idResponsable'+j).style.borderColor = '' 
                        : document.getElementById('Proceso_idResponsable'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoInvestigador.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idInvestigador'+j] === "undefined" ? document.getElementById('Tercero_idInvestigador'+j).style.borderColor = '' : document.getElementById('Tercero_idInvestigador'+j).style.borderColor = '#a94442');
                }

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


function firmarAccidente(idAccidente)
{
        var lastIdx = null;
        window.parent.$("#taccidenteselect").DataTable().ajax.url("http://"+location.host+"/datosAccidenteSelect?idAccidente="+idAccidente).load();
         // Abrir modal
        window.parent.$("#modalAccidente").modal()

        $("a.toggle-vis").on( "click", function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr("data-column") );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        window.parent.$("#taccidenteselect tbody").on( "mouseover", "td", function () 
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
        window.parent.$("#taccidenteselect tfoot th").each( function () 
        {
            var title = window.parent.$("#taccidenteselect thead th").eq( $(this).index() ).text();
            $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
        });
     
        // DataTable
        var table = window.parent.$("#taccidenteselect").DataTable();
     
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

        $("#taccidenteselect tbody").on( "click", "tr", function () 
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
                $("#idCoordinador").val(datos[0][1]);
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

        var idCoordinador = $("#idCoordinador").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idCoordinador' : idCoordinador, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaAccidente/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}