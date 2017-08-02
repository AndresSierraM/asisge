function validarFormulario(event)
{
    var route = "http://"+location.host+"/matrizriesgoproceso";
    var token = $("#token").val();
    var dato0 = document.getElementById('idMatrizRiesgoProceso').value;
    var dato1 = document.getElementById('fechaMatrizRiesgoProceso').value;
    var dato2 = document.getElementById('Tercero_idRespondable').value;
    var dato3 = document.getElementById('Proceso_idProceso').value;
 
 
    var observacionriesgo = document.querySelectorAll("[name='descripcionMatrizRiesgoProcesoDetalle[]']");
    
    var dato4 = [];
   

    
    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= observacionriesgo.length; j<i;j++)
    {
        dato4[j] = observacionriesgo[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idMatrizRiesgoProceso: dato0,
                fechaMatrizRiesgoProceso: dato1,
                Tercero_idRespondable: dato2,
                Proceso_idProceso: dato3,
                descripcionMatrizRiesgoProcesoDetalle: dato4, 
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
               
                (typeof msj.responseJSON.fechaMatrizRiesgoProceso === "undefined" ? document.getElementById('fechaMatrizRiesgoProceso').style.borderColor = '' : document.getElementById('fechaMatrizRiesgoProceso').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idRespondable === "undefined" ? document.getElementById('Tercero_idRespondable').style.borderColor = '' : document.getElementById('Tercero_idRespondable').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Proceso_idProceso === "undefined" ? document.getElementById('Proceso_idProceso').style.borderColor = '' : document.getElementById('Proceso_idProceso').style.borderColor = '#a94442');
               

         
                for(var j=0,i=observacionriesgo.length; j<i;j++)
                {
                    (typeof respuesta['descripcionMatrizRiesgoProcesoDetalle'+j] === "undefined" 
                        ? document.getElementById('descripcionMatrizRiesgoProcesoDetalle'+j).style.borderColor = '' 
                        : document.getElementById('descripcionMatrizRiesgoProcesoDetalle'+j).style.borderColor = '#a94442');
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

function CalcularNivelValor(registro, tipo)
{
    var Multiplicacion = 0;

    if (tipo == 'frecuencia')
    {   
        // Si es tipo frecuencia el va reemplzar el nombre por vacio para saber en que posicion va y del mismo modo si es impacto
        reg = registro.replace('frecuenciaMatrizRiesgoProcesoDetalle', '');
    }
    else if (tipo == 'impacto') 
    {
        reg = registro.replace('impactoMatrizRiesgoProcesoDetalle', '')
    }

    frecuencia = ($("#frecuenciaMatrizRiesgoProcesoDetalle"+reg).val() == '' ? 0 : $("#frecuenciaMatrizRiesgoProcesoDetalle"+reg).val());
    impacto = ($("#impactoMatrizRiesgoProcesoDetalle"+reg).val() == '' ? 0 : $("#impactoMatrizRiesgoProcesoDetalle"+reg).val());

    Multiplicacion = parseFloat(frecuencia) * parseFloat(impacto);

    $("#nivelValorMatrizRiesgoProcesoDetalle"+reg).val(Multiplicacion);

    // Variable que contiene el resultado de la condicion de la multiplicacion
    interpretacion = '';

    if (Multiplicacion ==  9)
    {
        interpretacion = "Alto";
    }
    else if (Multiplicacion == 1) 
    {
        interpretacion = 'Baja';
    }
    // Finalmene esta condicion  es diferente  se pregunt al mismo tiempo  >= 2 y <= 6 y adicional que sea diferente != 0 
    // para que cuando estn eligiendo la opcion no muestre  la palabra Media
    else if (Multiplicacion >= 2  || Multiplicacion <= 6 && Multiplicacion != 0) 
    {
        interpretacion = 'Media';
    }

    $("#interpretacionValorMatrizRiesgoProcesoDetalle"+reg).val(interpretacion);
}



