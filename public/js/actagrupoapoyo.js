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
    var datoResponsableTema = document.querySelectorAll("[name='Tercero_idResponsable[]']");
    var datoResponsableActividad = document.querySelectorAll("[name='Tercero_idResponsableDetalle[]']");
    var datoDocumento = document.querySelectorAll("[name='Documento_idDocumento[]']");
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    var dato8 = [];
    
    var valor = '';
    var sw = true;

    for(var j=0,i=datoParticipante.length; j<i;j++)
    {
        dato5[j] = datoParticipante[j].value;
    }

    for(var j=0,i=datoResponsableTema.length; j<i;j++)
    {
        dato6[j] = datoResponsableTema[j].value;
    }

    for(var j=0,i=datoResponsableActividad.length; j<i;j++)
    {
        dato7[j] = datoResponsableActividad[j].value;
    }

    for(var j=0,i=datoDocumento.length; j<i;j++)
    {
        dato8[j] = datoDocumento[j].value;
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
                Tercero_idResponsableDetalle: dato7,
                Documento_idDocumento: dato8
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

                for(var j=0,i=datoResponsableTema.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idResponsable'+j] === "undefined" ? document.getElementById('Tercero_idResponsable'+j).style.borderColor = '' : document.getElementById('Tercero_idResponsable'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoResponsableActividad.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idResponsableDetalle'+j] === "undefined" ? document.getElementById('Tercero_idResponsableDetalle'+j).style.borderColor = '' : document.getElementById('Tercero_idResponsableDetalle'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoDocumento.length; j<i;j++)
                {
                    (typeof respuesta['Documento_idDocumento'+j] === "undefined" ? document.getElementById('Documento_idDocumento'+j).style.borderColor = '' : document.getElementById('Documento_idDocumento'+j).style.borderColor = '#a94442');
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

