function validarFormulario(event)
{
    var route = "http://"+location.host+"/actagrupoapoyo";
    var token = $("#token").val();
    var dato0 = document.getElementById('idActaGrupoApoyo').value;
    var dato1 = document.getElementById('GrupoApoyo_idGrupoApoyo').value;
    var dato2 = document.getElementById('fechaActaGrupoApoyo').value;
    var dato3 = document.getElementById('horaInicioActaGrupoApoyo').value;
    var dato4 = document.getElementById('horaFinActaGrupoApoyo').value;


    var datoParticipante = document.querySelectorAll("[name='Tercero_idParticipante[]']");
    var responsabletema = document.querySelectorAll("[name='Tercero_idResponsable[]']");
    var responsableactividad = document.querySelectorAll("[name='Tercero_idResponsableDetalle[]']");



    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    
    
    var valor = '';
    var sw = true;

    for(var j=0,i=datoParticipante.length; j<i;j++)
    {
        dato5[j] = datoParticipante[j].value;
    }

    for(var j=0,i=responsabletema.length; j<i;j++)
    {
        dato6[j] = responsabletema[j].value;
    }

     for(var j=0,i=responsableactividad.length; j<i;j++)
    {
        dato7[j] = responsableactividad[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idActaGrupoApoyo: dato0,
                GrupoApoyo_idGrupoApoyo: dato1,
                fechaActaGrupoApoyo: dato2,
                horaInicioActaGrupoApoyo: dato3,
                horaFinActaGrupoApoyo: dato4, 
                Tercero_idParticipante: dato5, 
                Tercero_idResponsable: dato6,
                Tercero_idResponsableDetalle: dato7
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

                (typeof msj.responseJSON.GrupoApoyo_idGrupoApoyo === "undefined" ? document.getElementById('GrupoApoyo_idGrupoApoyo').style.borderColor = '' : document.getElementById('GrupoApoyo_idGrupoApoyo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaActaGrupoApoyo === "undefined" ? document.getElementById('fechaActaGrupoApoyo').style.borderColor = '' : document.getElementById('fechaActaGrupoApoyo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.horaInicioActaGrupoApoyo === "undefined" ? document.getElementById('horaInicioActaGrupoApoyo').style.borderColor = '' : document.getElementById('horaInicioActaGrupoApoyo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.horaFinActaGrupoApoyo === "undefined" ? document.getElementById('horaFinActaGrupoApoyo').style.borderColor = '' : document.getElementById('horaFinActaGrupoApoyo').style.borderColor = '#a94442');
               

                for(var j=0,i=datoParticipante.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idParticipante'+j] === "undefined" ? document.getElementById('Tercero_idParticipante'+j).style.borderColor = '' : document.getElementById('Tercero_idParticipante'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=responsabletema.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idResponsable'+j] === "undefined" ? document.getElementById('Tercero_idResponsable'+j).style.borderColor = '' : document.getElementById('Tercero_idResponsable'+j).style.borderColor = '#a94442');
                }

                 for(var j=0,i=responsableactividad.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idResponsableDetalle'+j] === "undefined" ? document.getElementById('Tercero_idResponsableDetalle'+j).style.borderColor = '' : document.getElementById('Tercero_idResponsableDetalle'+j).style.borderColor = '#a94442');
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

function firmarGrupoApoyo(idActa)
{
        var lastIdx = null;
        window.parent.$("#tactagrupoapoyoselect").DataTable().ajax.url("http://"+location.host+"/datosActaGrupoApoyoSelect?idActa="+idActa).load();
         // Abrir modal
        window.parent.$("#modalActaGrupoApoyo").modal()

        $("a.toggle-vis").on( "click", function (e) {
            e.preventDefault();
     
            // Get the column API object
            var column = table.column( $(this).attr("data-column") );
     
            // Toggle the visibility
            column.visible( ! column.visible() );
        } );

        window.parent.$("#tactagrupoapoyoselect tbody").on( "mouseover", "td", function () 
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
        window.parent.$("#tactagrupoapoyoselect tfoot th").each( function () 
        {
            var title = window.parent.$("#tactagrupoapoyoselect thead th").eq( $(this).index() ).text();
            $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
        });
     
        // DataTable
        var table = window.parent.$("#tactagrupoapoyoselect").DataTable();
     
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

        $("#tactagrupoapoyoselect tbody").on( "click", "tr", function () 
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
                $("#idParticipante").val(datos[0][2]);
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
        var idParticipante = $("#idParticipante").val();
        var firma = $("#firmabase64").val();

        var token = document.getElementById('token').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idActa' : idActa, 'idParticipante': idParticipante, 'firma': firma},
                url:   'http://'+location.host+'/actualizarFirmaActaGrupoApoyo/',
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