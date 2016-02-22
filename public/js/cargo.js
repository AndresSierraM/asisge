function validarFormulario(event)
{
    var route = "http://localhost:8000/cargo";
    var token = $("#token").val();
    var dato0 = document.getElementById('idCargo').value;
    var dato1 = document.getElementById('codigoCargo').value;
    var dato2 = document.getElementById('nombreCargo').value;
    var dato3 = document.getElementById('salarioBaseCargo').value;
    var datoTarea = document.querySelectorAll("[name='ListaGeneral_idTareaAltoRiesgo[]']");
    var datoVacuna = document.querySelectorAll("[name='ListaGeneral_idVacuna[]']");
    var datoElemento = document.querySelectorAll("[name='ListaGeneral_idElementoProteccion[]']");
    var datoExamen = document.querySelectorAll("[name='FrecuenciaMedicion_idFrecuenciaMedicion[]']");
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoTarea.length; j<i;j++)
    {
        dato4[j] = datoTarea[j].value;
    }

    for(var j=0,i=datoVacuna.length; j<i;j++)
    {
        dato5[j] = datoVacuna[j].value;
    }

    for(var j=0,i=datoElemento.length; j<i;j++)
    {
        dato6[j] = datoElemento[j].value;
    }

    for(var j=0,i=datoExamen.length; j<i;j++)
    {
        dato7[j] = datoExamen[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idCargo: dato0,
                codigoCargo: dato1,
                nombreCargo: dato2,
                salarioBaseCargo: dato3,
                ListaGeneral_idTareaAltoRiesgo: dato4, 
                ListaGeneral_idVacuna: dato5, 
                ListaGeneral_idElementoProteccion: dato6, 
                FrecuenciaMedicion_idFrecuenciaMedicion: dato7
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

                (typeof msj.responseJSON.codigoCargo === "undefined" ? document.getElementById('codigoCargo').style.borderColor = '' : document.getElementById('codigoCargo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreCargo === "undefined" ? document.getElementById('nombreCargo').style.borderColor = '' : document.getElementById('nombreCargo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.salarioBaseCargo === "undefined" ? document.getElementById('salarioBaseCargo').style.borderColor = '' : document.getElementById('salarioBaseCargo').style.borderColor = '#a94442');

                for(var j=0,i=datoTarea.length; j<i;j++)
                {
                    (typeof respuesta['ListaGeneral_idTareaAltoRiesgo'+j] === "undefined" ? document.getElementById('ListaGeneral_idTareaAltoRiesgo'+j).style.borderColor = '' : document.getElementById('ListaGeneral_idTareaAltoRiesgo'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoVacuna.length; j<i;j++)
                {
                    (typeof respuesta['ListaGeneral_idVacuna'+j] === "undefined" ? document.getElementById('ListaGeneral_idVacuna'+j).style.borderColor = '' : document.getElementById('ListaGeneral_idVacuna'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoElemento.length; j<i;j++)
                {
                    (typeof respuesta['ListaGeneral_idElementoProteccion'+j] === "undefined" ? document.getElementById('ListaGeneral_idElementoProteccion'+j).style.borderColor = '' : document.getElementById('ListaGeneral_idElementoProteccion'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoExamen.length; j<i;j++)
                {
                    (typeof respuesta['FrecuenciaMedicion_idFrecuenciaMedicion'+j] === "undefined" ? document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion'+j).style.borderColor = '' : document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion'+j).style.borderColor = '#a94442');
                }

                $("#msj").html('Los campos bordeados en rojo son obligatorios.');
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}

