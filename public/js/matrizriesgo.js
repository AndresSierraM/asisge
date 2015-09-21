function buscarTipoRiesgo(registro){

	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	var dato = document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo'+posicion).value;
	var token = document.getElementById('token').value;
	var id = document.getElementById('idMatrizRiesgo').value;

	$.ajax({
		async: true,
		headers: {'X-CSRF-TOKEN': token},
		url: 'http://localhost:8000/matrizriesgo/'+id,
		type: 'POST',
		dataType: 'JSON',
		method: 'GET',
		data: {clasificacionRiesgo: dato},
		success: function(data){
			var id = JSON.stringify(data[0]);
			var nombre = JSON.stringify(data[1]);

            var objetoId = JSON.parse(id);
            var objetoNombre = JSON.parse(nombre);
            var select = document.getElementById('TipoRiesgo_idTipoRiesgo'+posicion);
            
            var div = document.getElementById('TipoRiesgo_idTipoRiesgo'+posicion+'_chosen');
            /*aux = div.parentNode;
			aux.removeChild(div);*/
			div.setAttribute("style", 'display:none;');
			select.setAttribute("style", 'width: 110px;height:35px;');
			//select.setAttribute("class", '');
			select.options.length = 0;
            var option = '';
            for(var j=0,k=objetoId.length;j<k;j++)
            {
				var registroId =JSON.stringify(objetoId[j]);

				var valorId = JSON.parse(registroId);

				option = document.createElement('option');
                option.value = valorId.idTipoRiesgo;
                option.text = valorId.idTipoRiesgo;

                select.appendChild(option);

            }
            buscarDetalleTipoRiesgo('detalle_'+posicion);
            
            /*select.setAttribute("style", 'display:none;');
            div.setAttribute("style", 'width: 110px;');
            
            var config = {
		      '.chosen-select'           : {},
		      '.chosen-select-deselect'  : {allow_single_deselect:true},
		      '.chosen-select-no-single' : {disable_search_threshold:10},
		      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		      '.chosen-select-width'     : {width:"95%"}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }*/


        }
	});
}

function buscarDetalleTipoRiesgo(registro){

	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	var dato = document.getElementById('TipoRiesgo_idTipoRiesgo'+posicion).value;
	var token = document.getElementById('token').value;
	var id = document.getElementById('idMatrizRiesgo').value;

	$.ajax({
		async: true,
		headers: {'X-CSRF-TOKEN': token},
		url: 'http://localhost:8000/matrizriesgo/'+id,
		type: 'POST',
		dataType: 'JSON',
		method: 'GET',
		data: {tipoRiesgo: dato},
		success: function(data){
			
			var idDetalle = data[0];
			var nombreDetalle = data[1];
			var idSalud = data[2];
			var nombreSalud = data[3];

			var selectDetalle = document.getElementById('TipoRiesgoDetalle_idTipoRiesgoDetalle'+posicion);
			console.log(selectDetalle.value);
			var selectSalud = document.getElementById('TipoRiesgoSalud_idTipoRiesgoSalud'+posicion);
            
            //var div = document.getElementById('TipoRiesgoDetalle_idTipoRiesgoDetalle'+posicion+'_chosen');
            /*aux = div.parentNode;
			aux.removeChild(div);*/
			//div.setAttribute("style", 'display:none;');
			/*select.setAttribute("style", 'width: 110px;height:35px;');
			//select.setAttribute("class", '');*/
			selectDetalle.options.length = 0;
            var optionDetalle = '';
            for(var j=0,k=idDetalle.length;j<k;j++)
            {
            	optionDetalle = document.createElement('option');
                optionDetalle.value = idDetalle[j].idTipoRiesgoDetalle;
                optionDetalle.text = nombreDetalle[j].nombreTipoRiesgoDetalle;

                selectDetalle.appendChild(optionDetalle);
            }

            selectSalud.options.length = 0;
            var optionSalud = '';
            for(var j=0,k=idSalud.length;j<k;j++)
            {
            	optionSalud = document.createElement('option');
                optionSalud.value = idSalud[j].idTipoRiesgoSalud;
                optionSalud.text = nombreSalud[j].nombreTipoRiesgoSalud;

                selectSalud.appendChild(optionSalud);
            }
            
            /*select.setAttribute("style", 'display:none;');
            div.setAttribute("style", 'width: 110px;');
            
            var config = {
		      '.chosen-select'           : {},
		      '.chosen-select-deselect'  : {allow_single_deselect:true},
		      '.chosen-select-no-single' : {disable_search_threshold:10},
		      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		      '.chosen-select-width'     : {width:"95%"}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }*/


        }
	});
}

function calcularNiveles(registro){

    var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
    
    var campos = document.querySelectorAll(" div#detalle_"+posicion+"  select[name='nivelDeficienciaMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" select[name='nivelExposicionMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nivelProbabilidadMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nombreProbabilidadMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" select[name='nivelConsecuenciaMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nivelRiesgoMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nombreRiesgoMatrizRiesgoDetalle[]']");
    
    var nivelDeficiencia = campos[0];
    var nivelExposicion = campos[1];
    var nivelProbabilidad = campos[2];
    var nombreProbabilidad = campos[3];
    var nivelConsecuencia = campos[4];
    var nivelRiesgo = campos[5];
    var nombreRiesgo = campos[6];
    
    nivelProbabilidad.value = parseFloat(nivelDeficiencia.value) * parseFloat(nivelExposicion.value);

    if(nivelProbabilidad.value >= 24 && nivelProbabilidad.value <= 40)
    	nombreProbabilidad.value = 'Muy Alto';
    else if(nivelProbabilidad.value >=  10  && nivelProbabilidad.value <= 20)
    	nombreProbabilidad.value = 'Alto';
    else if(nivelProbabilidad.value >=  6 && nivelProbabilidad.value <= 8)
    	nombreProbabilidad.value = 'Medio';
    else if(nivelProbabilidad.value >=  2 && nivelProbabilidad.value <= 4)
    	nombreProbabilidad.value = 'Bajo';
    else if(nivelProbabilidad.value ==  0 )
    	nombreProbabilidad.value = '';	

    nivelRiesgo.value = parseFloat(nivelProbabilidad.value) * parseFloat(nivelConsecuencia.value);
    
    if(nivelRiesgo.value >= 600 && nivelRiesgo.value <= 4000)
    	nombreRiesgo.value = 'I';
    else if(nivelRiesgo.value >=  150  && nivelRiesgo.value <= 500)
    	nombreRiesgo.value = 'II';
    else if(nivelRiesgo.value >=  40  && nivelRiesgo.value <= 120)
    	nombreRiesgo.value = 'III';
    else if(nivelRiesgo.value ==  20)
    	nombreRiesgo.value = 'IV';
    else if(nivelRiesgo.value ==  0)
    	nombreRiesgo.value = '';												
	
}