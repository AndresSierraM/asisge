function consultarPlanCapacitacion()
{
	var id = document.getElementById('idActaCapacitacion').value;
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
            (datosEncabezado['cumpleObjetivoPlanCapacitacion'] == 1 ? document.getElementById('cumpleObjetivoPlanCapacitacion').checked = true : document.getElementById('cumpleObjetivoPlanCapacitacion').checked = false);

            for(var j=0,k=datosTemas.length;j<k;j++)
            {
            	tema.agregarCampos(JSON.stringify(datosTemas[j]),'L');
            }	
        }
    });
}