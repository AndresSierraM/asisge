function validarFormulario(event)
{
    var route = "http://"+location.host+"/plancapacitacion";
    var token = $("#token").val();
    var dato1 = document.getElementById('tipoPlanCapacitacion').value;
    var dato2 = document.getElementById('nombrePlanCapacitacion').value;
    var dato3 = document.getElementById('Tercero_idResponsable').value;
    var datoCapacitador = document.querySelectorAll("[name='Tercero_idCapacitador[]']");
    var datoFecha = document.querySelectorAll("[name='fechaPlanCapacitacionTema[]']");
    var datoHora = document.querySelectorAll("[name='horaPlanCapacitacionTema[]']");
    var datoNombre = document.querySelectorAll("[name='nombrePlanCapacitacionTema[]']");
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
        dato7[j] = datoNombre[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                tipoPlanCapacitacion: dato1,
                nombrePlanCapacitacion: dato2,
                Tercero_idResponsable: dato3,
                Tercero_idCapacitador: dato4, 
                fechaPlanCapacitacionTema: dato5, 
                horaPlanCapacitacionTema: dato6, 
                nombrePlanCapacitacionTema: dato7
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

                (typeof msj.responseJSON.tipoPlanCapacitacion === "undefined" ? document.getElementById('tipoPlanCapacitacion').style.borderColor = '' : document.getElementById('tipoPlanCapacitacion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombrePlanCapacitacion === "undefined" ? document.getElementById('nombrePlanCapacitacion').style.borderColor = '' : document.getElementById('nombrePlanCapacitacion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idResponsable === "undefined" ? document.getElementById('Tercero_idResponsable').style.borderColor = '' : document.getElementById('Tercero_idResponsable').style.borderColor = '#a94442');

                for(var j=0,i=datoCapacitador.length; j<i;j++)
                {
                    (typeof respuesta['nombrePlanCapacitacionTema'+j] === "undefined" ? document.getElementById('nombrePlanCapacitacionTema'+j).style.borderColor = '' : document.getElementById('nombrePlanCapacitacionTema'+j).style.borderColor = '#a94442');

                    (typeof respuesta['Tercero_idCapacitador'+j] === "undefined" ? document.getElementById('Tercero_idCapacitador'+j).style.borderColor = '' : document.getElementById('Tercero_idCapacitador'+j).style.borderColor = '#a94442');

                    (typeof respuesta['fechaPlanCapacitacionTema'+j] === "undefined" ? document.getElementById('fechaPlanCapacitacionTema'+j).style.borderColor = '' : document.getElementById('fechaPlanCapacitacionTema'+j).style.borderColor = '#a94442');

                    (typeof respuesta['horaPlanCapacitacionTema'+j] === "undefined" ? document.getElementById('horaPlanCapacitacionTema'+j).style.borderColor = '' : document.getElementById('horaPlanCapacitacionTema'+j).style.borderColor = '#a94442');
                }

                

                $("#msj").html('Los campos bordeados en rojo son obligatorios.');
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}