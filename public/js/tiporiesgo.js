function validarFormulario(event)
{
    var route = "http://"+location.host+"/tiporiesgo/";
    var token = $("#token").val();
    var dato1 = document.getElementById('codigoTipoRiesgo').value;
    var dato2 = document.getElementById('nombreTipoRiesgo').value;
    var dato3 = document.getElementById('origenTipoRiesgo').value;
    var dato4 = document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo').value;

    var datoDetalle = document.querySelectorAll("[name='nombreTipoRiesgoDetalle[]']");
    var datoSalud = document.querySelectorAll("[name='nombreTipoRiesgoSalud[]']");
    
    var dato5 = [];
    var dato6 = [];
    
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoDetalle.length; j<i;j++)
    {
        dato5[j] = datoDetalle[j].value;
    }
    for(var j=0,i=datoSalud.length; j<i;j++)
    {
        dato6[j] = datoSalud[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                codigoTipoRiesgo: dato1,
                nombreTipoRiesgo: dato2,
                origenTipoRiesgo: dato3,
                ClasificacionRiesgo_idClasificacionRiesgo: dato4,
                nombreTipoRiesgoDetalle: dato5, 
                nombreTipoRiesgoSalud: dato6
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
                mensaje = '';

                if(respuesta['codigoTipoRiesgo'])
                        mensaje += '<li>'+ respuesta['codigoTipoRiesgo']+"</li>";
                if(respuesta['nombreTipoRiesgo'])
                        mensaje += '<li>'+ respuesta['nombreTipoRiesgo']+"</li>";
                if(respuesta['origenTipoRiesgo'])
                        mensaje += '<li>'+ respuesta['origenTipoRiesgo']+"</li>";
                if(respuesta['ClasificacionRiesgo_idClasificacionRiesgo'])
                        mensaje += '<li>'+ respuesta['ClasificacionRiesgo_idClasificacionRiesgo']+"</li>";
                
                
                for(var j=0,i=datoDetalle.length; j<i;j++)
                {
                    if(respuesta['nombreTipoRiesgoDetalle'+j])
                        mensaje += '<li>'+ respuesta['nombreTipoRiesgoDetalle'+j]+"</li>";
                }

                for(var j=0,i=datoSalud.length; j<i;j++)
                {
                    if(respuesta['nombreTipoRiesgoSalud'+j])
                        mensaje += '<li>'+ respuesta['nombreTipoRiesgoSalud'+j]+"</li>";
                }

                $("#msj").html('Verifique los siguientes campos:<br>'+mensaje);
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}