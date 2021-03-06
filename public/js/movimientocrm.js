function valorDecimal(valor)
{
 
   $("#valorMovimientoCRM").val(addCommas(valor));

}
// Funcion independiente para que agregue las comas 
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function abrirModalVacante()
{   
    $('#ModalVacante').modal('show');

}
function cambiarEstado(id, TipoEstado, modificar, eliminar, consultar, aprobar)
{
    //$("#tmovimientocrm").DataTable().ajax.url('http://'+location.host+"/datosMovimientoCRM?idDocumento="+id+"&TipoEstado="+TipoEstado+"&modificar="+modificar+"&eliminar="+eliminar+"&consultar="+consultar+"&aprobar="+aprobar).load();
    location.href= 'http://'+location.host+"/movimientocrm?idDocumentoCRM="+id+"&TipoEstado="+TipoEstado+"&modificar="+modificar+"&eliminar="+eliminar+"&consultar="+consultar+"&aprobar="+aprobar;
}

function imprimirFormato(idMov, idDoc)
{
    window.open('movimientocrm/'+idMov+'?idDocumentoCRM='+idDoc+'&accion=imprimir','movimientocrm','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}

function mostrarTableroCRM(idDoc)
{
    window.open('movimientocrm/0?idDocumentoCRM='+idDoc+'&accion=dashboard','dashboardcrm','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}


function abrirModalMovimientos(idiframe, ruta, idDoc)
{
    var $iframe = $('#' + idiframe);
    if ( $iframe.length ) {
        $iframe.attr('src',ruta+'?idDocumentoCRM='+idDoc);   
        $('#ModalMovimientos').modal('show');
    }
}


function adicionarRegistros(nombreTabla, datos)
{
    if(datos.length >= 1) 
    {
        $("#MovimientoCRM_idBase").val(datos[i][0]);
        $("#numeroDocumentoBase").val(datos[i][1] + ' - ' + datos[i][2]);

        // luego de seleccionar el id de movimiento base, ejecutamos un ajax
        // que consulte el registro y lo traiga a los campos del formulario
        consultarMovimientoCRMBase(datos[i][0]);
    }
    $('#ModalMovimientos').modal('hide');
}


function consultarMovimientoCRMBase(idBase)
{   
    // con el id del movimiento debemos consultar los datos a
    // mostrar en el modal
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/consultarMovimientoCRMBase',
            type:  'post',
            data: {idBase : idBase},
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                console.log(respuesta);
                // asignamos los valores a los campos del modal
                if(respuesta["idMovimientoCRM"] !== null)
                {   
                    $("#asuntoMovimientoCRM").val(respuesta[0]["asuntoMovimientoCRM"]);
                    $("#prioridadMovimientoCRM").val(respuesta[0]["prioridadMovimientoCRM"]);
                    $("#Tercero_idSolicitante").val(respuesta[0]["Tercero_idSolicitante"]);
                    $("#CategoriaCRM_idCategoriaCRM").val(respuesta[0]["CategoriaCRM_idCategoriaCRM"]);
                    

                    CKEDITOR.instances['detallesMovimientoCRM'].setData(respuesta[0]["detallesMovimientoCRM"]);
                    CKEDITOR.instances['solucionMovimientoCRM'].setData(respuesta[0]["solucionMovimientoCRM"]);
                  
                }

            },
            error: function(xhr,err)
            { 
                console.log(xhr);
                alert("Error "+xhr);
            }
        });
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



function validarTipoTercero()
{
    document.getElementById("tipoTercero").value = '';

    for (tipo = 1; tipo <= 2; tipo++)
    {
        document.getElementById("tipoTercero").value = document.getElementById("tipoTercero").value + ((document.getElementById("tipoTercero" + (tipo)).checked) ? '*' + document.getElementById("tipoTercero" + (tipo)).value + '*' : '');
    }
    mostrarPestanas();
}

function seleccionarTipoTercero()
{
    for (tipo = 1; tipo <= 2; tipo++)
    {
        if (document.getElementById("tipoTercero").value.indexOf('*' + document.getElementById("tipoTercero" + (tipo)).value + '*') >= 0)
        {
            document.getElementById("tipoTercero" + (tipo)).checked = true;
        }
        else
        {
            document.getElementById("tipoTercero" + (tipo)).checked = false;
        }
    }

    mostrarPestanas();

}

function llenaNombreTercero()
{
    nombre1 = document.getElementById('nombre1Tercero').value;
    nombre2 = document.getElementById('nombre2Tercero').value;
    apellido1 = document.getElementById('apellido1Tercero').value;
    apellido2 = document.getElementById('apellido2Tercero').value;

    document.getElementById('nombreCompletoTercero').value = nombre1 + ' ' + nombre2 + ' ' + apellido1 + ' ' + apellido2;
}

function mostrarPestanas()
{
    if(document.getElementById('tipoTercero1').checked)
    {
        document.getElementById('cargo').style.display = 'inline';
        document.getElementById('pestanaProducto').style.display = 'none';
        document.getElementById('pestanaEducacion').style.display = 'block';
        document.getElementById('pestanaExperiencia').style.display = 'block';
        document.getElementById('pestanaFormacion').style.display = 'block';
        document.getElementById('pestanaPersonal').style.display = 'block';
        document.getElementById('pestanaLaboral').style.display = 'block';
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

    if(document.getElementById('tipoTercero2').checked)
    {
        document.getElementById('cargo').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'block';
        document.getElementById('pestanaEducacion').style.display = 'none';
        document.getElementById('pestanaExperiencia').style.display = 'none';
        document.getElementById('pestanaFormacion').style.display = 'none';
        document.getElementById('pestanaPersonal').style.display = 'none';
        document.getElementById('pestanaLaboral').style.display = 'none';
    }
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


function mostrarModalAsesor(idMovimientoCRM)
{   
    // con el id del movimiento debemos consultar los datos a
    // mostrar en el modal
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/consultarAsesorMovimientoCRM',
            type:  'post',
            data: {idMovimientoCRM : idMovimientoCRM},
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                // asignamos los valores a los campos del modal
                if(respuesta["Tercero_idSupervisor"] !== null)
                {   
                    $("#Tercero_idSupervisor").val(respuesta["Tercero_idSupervisor"]);
                    $("#nombreCompletoSupervisor").val(respuesta["nombreCompletoSupervisor"]);
                }
                $('#Tercero_idAsesor > option[value="'+respuesta["Tercero_idAsesor"]+'"]').attr('selected', 'selected');
                $('#AcuerdoServicio_idAcuerdoServicio > option[value="'+respuesta["AcuerdoServicio_idAcuerdoServicio"]+'"]').attr('selected', 'selected');
                $("#diasEstfichatecnicaadosSolucionMovimientoCRM").val(respuesta["diasEstfichatecnicaadosSolucionMovimientoCRM"]);

            },
            error: function(xhr,err)
            { 
                console.log(xhr);
                alert("Error "+xhr);
            }
        });
    
    $("#idMovimientoCRM").val(idMovimientoCRM);
    $("#ModalAsesor").modal("show");
}

function mostrarDiasAcuerdo(idAcuerdo)
{   
    // con el id del movimiento debemos consultar los datos a
    // mostrar en el modal
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/consultarDiasAcuerdoServicio',
            type:  'post',
            data: {idAcuerdo : idAcuerdo},
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                
                // asignamos los valores a los campos del modal
                if(respuesta["tiempoAcuerdoServicio"] !== null)
                {   
                    $("#diasEstfichatecnicaadosSolucionMovimientoCRM").val(respuesta["tiempoAcuerdoServicio"]);
                }

            },
            error: function(xhr,err)
            { 
                console.log(xhr);
                alert("Error "+xhr);
            }
        });
}

function guardarAsesor()
{   
    var idMovimientoCRM = $("#idMovimientoCRM").val();
    var idSupervisor = $("#Tercero_idSupervisor").val();
    var idAsesor = $("#Tercero_idAsesor").val();
    var idAcuerdo = $("#AcuerdoServicio_idAcuerdoServicio").val();
    var diasAcuerdo = $("#diasEstimadosSolucionMovimientoCRM").val();

    
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/guardarAsesorMovimientoCRM',
            type:  'post',
            data: {idMovimientoCRM : idMovimientoCRM,
                    idSupervisor: idSupervisor,
                    idAsesor: idAsesor,
                    idAcuerdo: idAcuerdo,
                    diasAcuerdo: diasAcuerdo},
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                
                alert(respuesta[1]);
                $("#ModalAsesor").modal("hide");
                
            },
            error: function(xhr,err)
            { 
                console.log(xhr);
                alert("Error "+xhr);
            }
        });
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

function abrirModalEvento()
{
    $("#modalEvento").modal("show");
}

function agregarRegistroTareaCRM(idCategoria, nombreCategoria, asuntoAgenda, ubicacionAgenda, fechaHoraInicioAgenda, fechaHoraFinAgenda, idResponsable, nombreResponsable, estadoAgenda)
{    
    if (idCategoria == 0) 
    {
        alert('Debe seleccionar una categoría.');
        $("#CategoriaAgenda_idCategoriaAgenda").css("background-color", "red");
        $("#asuntoAgenda").css("background-color", "");
        $("#ubicacionAgenda").css("background-color", "");
        $("#Tercero_idResponsable").css("background-color", "");
    }
    else if (asuntoAgenda == '') 
    {
        alert('Debe digitar un asunto.');
        $("#asuntoAgenda").css("background-color", "red");
        $("#ubicacionAgenda").css("background-color", "");
        $("#CategoriaAgenda_idCategoriaAgenda").css("background-color", "");
        $("#Tercero_idResponsable").css("background-color", "red");
    }
    else if (idResponsable == 0) 
    {
        alert('Debe seleccionar un responsable.');
        $("#Tercero_idResponsable").css("background-color", "red");
        $("#asuntoAgenda").css("background-color", "");
        $("#ubicacionAgenda").css("background-color", "");
        $("#CategoriaAgenda_idCategoriaAgenda").css("background-color", "");
    }
    else
    {
        var valores = new Array(idCategoria, nombreCategoria, asuntoAgenda, ubicacionAgenda, fechaHoraInicioAgenda, fechaHoraFinAgenda, 0, idResponsable, nombreResponsable,0, 0, estadoAgenda, 0);
        window.parent.tareas.agregarCampos(valores,'A');  
        window.parent.$("#modalEvento").modal("hide");
    }   
}

function calcularHoras()
{
    regFin = tareas.contador -1;
    totHoras = 0;
    porEjec = 0;
    if ($("#fechaHoraInicioAgenda").val() == '' || $("#horasDiaAgenda").val() == '')
    {
        alert('Vetifique que los campos fecha de inicio horas a trabajar al día estén llenos.')
    }
    else
    {
        for (var i = 0; i < tareas.contador; i++) 
        {
            if (i == 0) 
            {
                $("#fechaInicioAgendaTarea"+i).val($("#fechaHoraInicioAgenda").val());
                fechaFin = sumarHoras($("#fechaInicioAgendaTarea"+i).val(), $("#horasAgendaTarea"+i).val(), $("#horasDiaAgenda").val())
                $("#fechaFinAgendaTarea"+i).val(fechaFin);
            }
            else
            {
                regAnt = i-1;
                $("#fechaInicioAgendaTarea"+i).val($("#fechaFinAgendaTarea"+regAnt).val());
                fechaFin = sumarHoras($("#fechaInicioAgendaTarea"+i).val(), $("#horasAgendaTarea"+i).val(), $("#horasDiaAgenda").val())
                $("#fechaFinAgendaTarea"+i).val(fechaFin);
            }

            if (i == regFin) 
            {
                $("#fechaHoraEstfichatecnicaadaFinAgenda").val($("#fechaFinAgendaTarea"+i).val());
            }

            totHoras += parseFloat($("#horasAgendaTarea"+i).val());
            porEjec += (parseFloat($("#pesoAgendaTarea"+i).val()) * parseFloat($("#ejecuionAgendaTarea"+i).val()))/100;

        }

        $("#tiempoTotalAgendaTarea").val(totHoras);
        $("#porcentajeCumplimientoAgendaTarea").val(porEjec);

        calcularPesoTarea($("#tiempoTotalAgendaTarea").val());
    }
}

function calcularPesoTarea(tothoras)
{
    for (var i = 0; i < tareas.contador; i++) 
    {
        peso = (parseFloat($("#horasAgendaTarea"+i).val()) / tothoras)*100;

        $("#pesoAgendaTarea"+i).val(peso);
    }
}

function sumarHoras(fechaInicial, horaTrabajar, horaDia)
{
    horas = horaTrabajar/horaDia;

    sum = (horaTrabajar >= 1 ? 86400 : 3600);

    fechaIni = fechaInicial;
    //Dividimos la fecha primero utilizando el espacio para obtener solo la fecha y el tiempo por separado
    var splitDate= fechaIni.split(" ");
    var date=splitDate[0].split("-");
    var tfichatecnicae=splitDate[1].split(":");

    // Obtenemos los campos individuales para todas las partes de la fecha
    var dd =date[0];
    var mm=date[1]-1;
    var yyyy=date[2];
    var hh=tfichatecnicae[0];
    var min=tfichatecnicae[1];
    var ss=tfichatecnicae[2];

    // Creamos la fecha con Javascript
    var fecha = new Date(yyyy,mm,dd,hh,min,ss);
    dia = fecha.getDate();
    mes = fecha.getMonth() + 1;
    anio = fecha.getFullYear();
    addtfichatecnicae = horas * sum; //Tiempo en segundos
 
    fecha.setSeconds(addtfichatecnicae); //Añado el tiempo

    var fechastring = ("0" + fecha.getDate()).slice(-2) + '-' + ("0" + (fecha.getMonth() + 1)).slice(-2) + '-' + fecha.getFullYear() + ' ' + ("0" + fecha.getHours()).slice(-2) + ':' + ("0" + fecha.getMinutes()).slice(-2) + ':' + ("0" + fecha.getSeconds()).slice(-2);

    return fechastring;
}

function asignarFechAgenda(inicio, fin, reg)
{
    var inicio = new Date();
    var fechaInicial = ("0" + inicio.getDate()).slice(-2) + '-' + ("0" + (inicio.getMonth() + 1)).slice(-2) + '-' + inicio.getFullYear() + ' ' + ("0" + inicio.getHours()).slice(-2) + ':' + ("0" + inicio.getMinutes()).slice(-2) + ':' + ("0" + inicio.getSeconds()).slice(-2);

    var fin = new Date();
    var fechaFinal = ("0" + fin.getDate()).slice(-2) + '-' + ("0" + (fin.getMonth() + 1)).slice(-2) + '-' + fin.getFullYear() + ' ' + ("0" + fin.getHours()).slice(-2) + ':' + ("0" + fin.getMinutes()).slice(-2) + ':' + ("0" + fin.getSeconds()).slice(-2);

    $("#fechaInicioAgendaTarea"+reg).val(fechaInicial);
    $("#fechaFinAgendaTarea"+reg).val(fechaFinal);

    $("#fechaHoraInicioAgenda").val(fechaInicial);
    $("#fechaHoraEstfichatecnicaadaFinAgenda").val(fechaFinal);
} 

function abrirModalFichaTecnica()
{

    idTercero = ($("#Tercero_idProveedor").val() == '' ? '' : $("#Tercero_idProveedor").val());

    window.parent.$("#tfichatecnica tbody tr").each( function () 
    {
        $(this).removeClass('selected');
    });

    var lastIdx = null;
    window.parent.$("#tfichatecnica").DataTable().ajax.url('http://'+location.host+"/datosFichaTecnicaModal?ficha=crm&idTercero="+idTercero).load();
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
            var valores = new Array(datos[i][2], datos[i][0], datos[i][1], '1', '1', '1');
            window.parent.productoservicio.agregarCampos(valores,'A');
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
        reg = registro.replace('cantidadMovimientoCRMProducto','');
    }
    else if(tipo == 'unitario')
    {
        reg = registro.replace('valorUnitarioMovimientoCRMProducto','');   
    }

    valor = parseFloat($("#cantidadMovimientoCRMProducto"+reg).val()) * parseFloat($("#valorUnitarioMovimientoCRMProducto"+reg).val());

    $("#valorTotalMovimientoCRMProducto"+reg).val(valor)

    calcularTotales();
    
}

function calcularTotales()
{
    total = 0;

    for (var i = 0; i < window.parent.productoservicio.contador; i++) 
    {
        total += parseFloat($("#valorTotalMovimientoCRMProducto"+i, window.parent.document).val());
    }
            
    $('#totalProducto', window.parent.document).val(total);
}