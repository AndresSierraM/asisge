function buscarAusentismo(){

	var idEmpleado = document.getElementById('Tercero_idEmpleado').value;
	var token = document.getElementById('token').value;

	$.ajax({
		headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idEmpleado' : idEmpleado},
            url:   'http://'+location.host+'/llenarAusentismo/',
            type:  'post',
		success: function(data){
            
            var select = document.getElementById('Ausentismo_idAusentismo');
            
            select.options.length = 0;
            var option = '';

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione la Ausencia...';
            select.appendChild(option);

            for(var j=0,k=data.length;j<k;j++)
            {
				option = document.createElement('option');
                option.value = data[j].idAusentismo;
                option.text = data[j].nombreAusentismo;
                option.selected = (document.getElementById("Ausentismo_idAusentismo").value == data[j].idAusentismo ? true : false);
                select.appendChild(option);

            }

        }
	});
}
