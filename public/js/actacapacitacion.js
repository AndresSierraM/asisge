function consultarPlanCapacitacion()
{
    var id = (document.getElementById('idActaCapacitacion').value == '' ? 0 : document.getElementById('idActaCapacitacion').value) ;
    var dato1 = document.getElementById('PlanCapacitacion_idPlanCapacitacion').value;
	var route = "http://localhost:8000/actacapacitacion/"+id;
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
            document.getElementById('objetivoPlanCapacitacion').value = datosEncabezado['objetivoPlanCapacitacion'].replace('<p>','').replace('</p>','');
            document.getElementById('cumpleObjetivoPlanCapacitacion').value = datosEncabezado['cumpleObjetivoPlanCapacitacion'];
            document.getElementById('fechaFinPlanCapacitacion').value = datosEncabezado['fechaFinPlanCapacitacion'];
            document.getElementById('fechaInicioPlanCapacitacion').value = datosEncabezado['fechaInicioPlanCapacitacion'];
            document.getElementById('metodoEficaciaPlanCapacitacion').value = datosEncabezado['metodoEficaciaPlanCapacitacion'].replace('<p>','').replace('</p>','');
            document.getElementById('personalInvolucradoPlanCapacitacion').value = datosEncabezado['personalInvolucradoPlanCapacitacion'].replace('<p>','').replace('</p>','');
           

            for(var j=0,k=datosTemas.length;j<k;j++)
            {
            	tema.agregarCampos(JSON.stringify(datosTemas[j]),'L');
            }	
        }
    });
}

function validarFormulario(event)
{
    var route = "http://localhost:8000/actacapacitacion";
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