
function validarFormulario(event)
{
    var route = "http://"+location.host+"/tipoinspeccion/";
    var token = $("#token").val();
    var dato1 = document.getElementById('codigoTipoInspeccion').value;
    var dato2 = document.getElementById('nombreTipoInspeccion').value;
    var dato3 = document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').value;

    var datoNumero = document.querySelectorAll("[name='numeroTipoInspeccionPregunta[]']");
    var datoContenido = document.querySelectorAll("[name='contenidoTipoInspeccionPregunta[]']");
    
    var dato4 = [];
    var dato5 = [];
    
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoNumero.length; j<i;j++)
    {
        dato4[j] = datoNumero[j].value;
        dato5[j] = datoContenido[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                codigoTipoInspeccion: dato1,
                nombreTipoInspeccion: dato2,
                FrecuenciaMedicion_idFrecuenciaMedicion: dato3,
                numeroTipoInspeccionPregunta: dato4, 
                contenidoTipoInspeccionPregunta: dato5
                },
        success:function(){
            //$("#msj-success").fadeIn();
            console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            var respuesta = JSON.stringify(msj.responseJSON); 
            
            if(typeof respuesta === "undefined")
            {
                sw = true;
                $("#msj").html('');
                $("#msj-error").fadeOut();
            }
            else
            {
                sw = false;
                respuesta = JSON.parse(respuesta);
                mensaje = '';

                if(respuesta['codigoTipoInspeccion'])
                        mensaje += '<li>'+ respuesta['codigoTipoInspeccion']+"</li>";
                if(respuesta['nombreTipoInspeccion'])
                        mensaje += '<li>'+ respuesta['nombreTipoInspeccion']+"</li>";
                if(respuesta['FrecuenciaMedicion_idFrecuenciaMedicion'])
                        mensaje += '<li>'+ respuesta['FrecuenciaMedicion_idFrecuenciaMedicion']+"</li>";
                
                
                for(var j=0,i=datoNumero.length; j<i;j++)
                {
                    if(respuesta['numeroTipoInspeccionPregunta'+j])
                        mensaje += '<li>'+ respuesta['numeroTipoInspeccionPregunta'+j]+"</li>";

                    if(respuesta['contenidoTipoInspeccionPregunta'+j])
                        mensaje += '<li>'+ respuesta['contenidoTipoInspeccionPregunta'+j]+"</li>";
                }

                $("#msj").html('Verifique los siguientes campos:<br>'+mensaje);
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === false)
        event.preventDefault();
    
    
}