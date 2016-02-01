function buscarProceso(){

	var dato = document.getElementById('PlanAuditoria_idPlanAuditoria').value;
	var token = document.getElementById('token').value;
	var id = document.getElementById('idListaChequeo').value;

	$.ajax({
		async: true,
		headers: {'X-CSRF-TOKEN': token},
		url: 'http://localhost:8000/listachequeo/'+id,
		type: 'POST',
		dataType: 'JSON',
		method: 'GET',
		data: {planAuditoria: dato},
		success: function(data){
			var id = data[0];
			var nombre = data[1];
            var proceso = (data[2][0] ? data[2][0].Proceso_idProceso : '');
            
            var select = document.getElementById('Proceso_idProceso');
            
            select.options.length = 0;
            var option = '';

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione...';
            select.appendChild(option);

            for(var j=0,k=id.length;j<k;j++)
            {
				option = document.createElement('option');
                option.value = id[j].idProceso;
                option.text = nombre[j].nombreProceso;
                option.selected = (proceso == id[j].idProceso ? true : false);
                select.appendChild(option);
		    }
        }
	});
}

