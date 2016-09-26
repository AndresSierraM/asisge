function consultarPlanCapacitacion(tipo)
{
    if(document.getElementById('PlanCapacitacion_idPlanCapacitacion').value == '')
        return;

    var id = (document.getElementById('idActaCapacitacion').value == '' ? 0 : document.getElementById('idActaCapacitacion').value) ;
    var dato1 = document.getElementById('PlanCapacitacion_idPlanCapacitacion').value;
    
    var route = "http://"+location.host+"/actacapacitacion/"+id;
    var token = $("#token").val();

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
		method: 'GET',
        type: 'POST',
        dataType: 'json',
        data: {idPlanCapacitacion: dato1},
        success:function(data){
            var datosEncabezado = data[0];
            var datosTemas = data[1];
            var tercero = data[2];
            

            document.getElementById('tipoPlanCapacitacion').value = datosEncabezado['tipoPlanCapacitacion'];
            document.getElementById('nombreResponsable').value = tercero['nombreCompletoTercero'];
            document.getElementById('objetivoPlanCapacitacion').innerHTML = datosEncabezado['objetivoPlanCapacitacion'].replace('<p>','').replace('</p>','');
            document.getElementById('fechaFinPlanCapacitacion').value = datosEncabezado['fechaFinPlanCapacitacion'];
            document.getElementById('fechaInicioPlanCapacitacion').value = datosEncabezado['fechaInicioPlanCapacitacion'];
            document.getElementById('metodoEficaciaPlanCapacitacion').innerHTML = datosEncabezado['metodoEficaciaPlanCapacitacion'].replace('<p>','').replace('</p>','');
            document.getElementById('personalInvolucradoPlanCapacitacion').innerHTML = datosEncabezado['personalInvolucradoPlanCapacitacion'].replace('<p>','').replace('</p>','');
           
            
            if(tipo == 'Completo')
            {
                // primero eliminamos los registros actuales, para qu eno se combinen temas de diferentes planes cuando el usuario cambie de plan
                tema.borrarTodosCampos();


                for(var j=0,k=datosTemas.length;j<k;j++)
                {
                	tema.agregarCampos(JSON.stringify(datosTemas[j]),'L');
                }
            }	 

        }
    });
}

function validarFormulario(event)
{
    var route = "http://"+location.host+"/actacapacitacion";
    var token = $("#token").val();
    var dato0 = document.getElementById('idActaCapacitacion').value;
    var dato1 = document.getElementById('numeroActaCapacitacion').value;
    var dato2 = document.getElementById('fechaElaboracionActaCapacitacion').value;
    var dato3 = document.getElementById('PlanCapacitacion_idPlanCapacitacion').value;
    var datoCapacitador = document.querySelectorAll("[name='Tercero_idCapacitador[]']");
    var datoFecha = document.querySelectorAll("[name='fechaPlanCapacitacionTema[]']");
    var datoHora = document.querySelectorAll("[name='horaPlanCapacitacionTema[]']");
    var datoAsistente = document.querySelectorAll("[name='Tercero_idAsistente[]']");
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoCapacitador.length; j<i;j++)
    {
        dato4[j] = datoCapacitador[j].value;
        dato5[j] = datoFecha[j].value;
        dato6[j] = datoHora[j].value;
    }

    for(var j=0,i=datoAsistente.length; j<i;j++)
    {
        dato7[j] = datoAsistente[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idActaCapacitacion: dato0,
                numeroActaCapacitacion: dato1,
                fechaElaboracionActaCapacitacion: dato2,
                PlanCapacitacion_idPlanCapacitacion: dato3,
                Tercero_idCapacitador: dato4, 
                fechaPlanCapacitacionTema: dato5, 
                horaPlanCapacitacionTema: dato6, 
                Tercero_idAsistente: dato7
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            var respuesta = JSON.stringify(msj.responseJSON); 
            console.log(respuesta);
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

                (typeof msj.responseJSON.numeroActaCapacitacion === "undefined" ? document.getElementById('numeroActaCapacitacion').style.borderColor = '' : document.getElementById('numeroActaCapacitacion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionActaCapacitacion === "undefined" ? document.getElementById('fechaElaboracionActaCapacitacion').style.borderColor = '' : document.getElementById('fechaElaboracionActaCapacitacion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.PlanCapacitacion_idPlanCapacitacion === "undefined" ? document.getElementById('PlanCapacitacion_idPlanCapacitacion').style.borderColor = '' : document.getElementById('PlanCapacitacion_idPlanCapacitacion').style.borderColor = '#a94442');

                for(var j=0,i=datoCapacitador.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idCapacitador'+j] === "undefined" ? document.getElementById('Tercero_idCapacitador'+j).style.borderColor = '' : document.getElementById('Tercero_idCapacitador'+j).style.borderColor = '#a94442');

                    (typeof respuesta['fechaPlanCapacitacionTema'+j] === "undefined" ? document.getElementById('fechaPlanCapacitacionTema'+j).style.borderColor = '' : document.getElementById('fechaPlanCapacitacionTema'+j).style.borderColor = '#a94442');

                    (typeof respuesta['horaPlanCapacitacionTema'+j] === "undefined" ? document.getElementById('horaPlanCapacitacionTema'+j).style.borderColor = '' : document.getElementById('horaPlanCapacitacionTema'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoAsistente.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idAsistente'+j] === "undefined" ? document.getElementById('Tercero_idAsistente'+j).style.borderColor = '' : document.getElementById('Tercero_idAsistente'+j).style.borderColor = '#a94442');

                }

                $("#msj").html('Los campos bordeados en rojo son obligatorios.');
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}

function llenarCargo(Tercero)
{

     var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idTercero': Tercero.value},
            url:   'http://'+location.host+'/llenarCargo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                reg = Tercero.id.replace('Tercero_idAsistente','');
                //lo que se si el destino devuelve algo
                $("#nombreCargo"+reg).val(respuesta); //Al input nombreCargo le envío la respuesta de la consulta
                                                  //realizada en llenarCargo
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });
}

function llenarPlanCapacitacionTema(Plan)
{

     var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idPlanCapacitacionTema': Plan.value},
            url:   'http://'+location.host+'/llenarPlanCapacitacionTema/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                reg = Plan.id.replace('PlanCapacitacionTema_idPlanCapacitacionTema','');
                //lo que se si el destino devuelve algo
                $("#nombrePlanCapacitacionTema"+reg).val(respuesta); //Al input nombrePlanCapacitacionTema le envío la respuesta de la consulta
                                                  //realizada en llenarPlanCapacitacionTema
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });
}

function firmarActaCapacitacion(idActa)
{
        var lastIdx = null;
        window.parent.$("#tactacapacitacionselect").DataTable().ajax.url("http://"+location.host+"/datosActaCapacitacionSelect?idActa="+idActa).load();
         // Abrir modal
        window.parent.$("#modalActaCapacitacion").modal()

        $("a.toggle-vis").on( "click", function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr("data-column") );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        window.parent.$("#tactacapacitacionselect tbody").on( "mouseover", "td", function () 
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
        window.parent.$("#tactacapacitacionselect tfoot th").each( function () 
        {
            var title = window.parent.$("#tactacapacitacionselect thead th").eq( $(this).index() ).text();
            $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
        });
     
        // DataTable
        var table = window.parent.$("#tactacapacitacionselect").DataTable();
     
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

        $("#tactacapacitacionselect tbody").on( "click", "tr", function () 
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
                $("#idActa").val(datos[0][1]);
                $("#idAsistente").val(datos[0][2]);
                signaturePad.clear();
                mostrarFirma();
            }

        });
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

        var idActa = $("#idActa").val();
        var idAsistente = $("#idAsistente").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idActa' : idActa, 'idAsistente': idAsistente, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaActaCapacitacion/',
                type:  'post',
            success: function(respuesta)
            {
                alert(respuesta);
            }
        });
    
    }
}

function cerrarDivFirma()
{
    document.getElementById("signature-pad").style.display = "none";
}