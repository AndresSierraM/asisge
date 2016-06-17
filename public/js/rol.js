function validarFormulario(event)
{
    var route = "http://"+location.host+"/rol";
    var token = $("#token").val();
    var dato1 = document.getElementById('codigoRol').value;
    var dato2 = document.getElementById('nombreRol').value;
    
    var datoOpcion = document.querySelectorAll("[name='Opcion_idOpcion[]']");
    var dato3 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoOpcion.length; j<i;j++)
    {
        dato3[j] = datoOpcion[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                codigoRol: dato1,
                nombreRol: dato2,
                Opcion_idOpcion: dato3, 
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

                if(respuesta['codigoRol'])
                        mensaje += '<li>'+ respuesta['codigoRol']+"</li>";
                if(respuesta['nombreRol'])
                        mensaje += '<li>'+ respuesta['nombreRol']+"</li>";
                
                
                for(var j=0,i=datoOpcion.length; j<i;j++)
                {
                    if(respuesta['Opcion_idOpcion'+j])
                        mensaje += '<li>'+ respuesta['Opcion_idOpcion'+j]+"</li>";
                }

                $("#msj").html('Verifique los siguientes campos:<br>'+mensaje);
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}
