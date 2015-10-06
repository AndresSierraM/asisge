function buscarTipoRiesgo(registro){

	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	var dato = document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo'+posicion).value;
	var token = document.getElementById('token').value;
	var id = document.getElementById('idMatrizRiesgoDetalle'+posicion).value;

	$.ajax({
		async: true,
		headers: {'X-CSRF-TOKEN': token},
		url: 'http://localhost:8000/matrizriesgo/'+id,
		type: 'POST',
		dataType: 'JSON',
		method: 'GET',
		data: {clasificacionRiesgo: dato},
		success: function(data){
			var id = data[0];
			var nombre = data[1];
            var tipoRiesgo = (data[2][0] ? data[2][0].TipoRiesgo_idTipoRiesgo : '');
            
            var select = document.getElementById('TipoRiesgo_idTipoRiesgo'+posicion);
            
            select.options.length = 0;
            var option = '';

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione...';
            select.appendChild(option);

            for(var j=0,k=id.length;j<k;j++)
            {
				option = document.createElement('option');
                option.value = id[j].idTipoRiesgo;
                option.text = nombre[j].nombreTipoRiesgo;
                option.selected = (tipoRiesgo == id[j].idTipoRiesgo ? true : false);
                select.appendChild(option);

            }
            buscarDetalleTipoRiesgo('detalle_'+posicion);
        }
	});
}

function buscarDetalleTipoRiesgo(registro){

	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	var dato = document.getElementById('TipoRiesgo_idTipoRiesgo'+posicion).value;
	var token = document.getElementById('token').value;
	var id = document.getElementById('idMatrizRiesgoDetalle'+posicion).value;

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
            var tipoRiesgoDetalle = (data[4][0] ? data[4][0].TipoRiesgoDetalle_idTipoRiesgoDetalle : '');
            var tipoRiesgoSalud = (data[4][0] ? data[4][0].TipoRiesgoSalud_idTipoRiesgoSalud : '');
			var selectDetalle = document.getElementById('TipoRiesgoDetalle_idTipoRiesgoDetalle'+posicion);
			var selectSalud = document.getElementById('TipoRiesgoSalud_idTipoRiesgoSalud'+posicion);
            
            selectDetalle.options.length = 0;
            var optionDetalle = '';

            optionDetalle = document.createElement('option');
            optionDetalle.value = '';
            optionDetalle.text = 'Seleccione...';
            selectDetalle.appendChild(optionDetalle);

            for(var j=0,k=idDetalle.length;j<k;j++)
            {
            	optionDetalle = document.createElement('option');
                optionDetalle.value = idDetalle[j].idTipoRiesgoDetalle;
                optionDetalle.text = nombreDetalle[j].nombreTipoRiesgoDetalle;
                optionDetalle.selected = (tipoRiesgoDetalle == idDetalle[j].idTipoRiesgoDetalle ? true : false);
                selectDetalle.appendChild(optionDetalle);
            }

            selectSalud.options.length = 0;
            var optionSalud = '';

            optionSalud = document.createElement('option');
            optionSalud.value = '';
            optionSalud.text = 'Seleccione...';
            selectSalud.appendChild(optionSalud);

            for(var j=0,k=idSalud.length;j<k;j++)
            {
            	optionSalud = document.createElement('option');
                optionSalud.value = idSalud[j].idTipoRiesgoSalud;
                optionSalud.text = nombreSalud[j].nombreTipoRiesgoSalud;
                optionSalud.selected = (tipoRiesgoSalud == idSalud[j].idTipoRiesgoSalud ? true : false);
                selectSalud.appendChild(optionSalud);
            }
            
        }
	});
}

function calcularNiveles(registro){

    var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
    
    var campos = document.querySelectorAll(" div#detalle_"+posicion+"  select[name='nivelDeficienciaMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" select[name='nivelExposicionMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nivelProbabilidadMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nombreProbabilidadMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" select[name='nivelConsecuenciaMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nivelRiesgoMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='nombreRiesgoMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='aceptacionRiesgoMatrizRiesgoDetalle[]']");
    
    var nivelDeficiencia = campos[0];
    var nivelExposicion = campos[1];
    var nivelProbabilidad = campos[2];
    var nombreProbabilidad = campos[3];
    var nivelConsecuencia = campos[4];
    var nivelRiesgo = campos[5];
    var nombreRiesgo = campos[6];
    var aceptacionRiesgo = campos[7];
    
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
    {	
        nombreRiesgo.value = 'I';
        aceptacionRiesgo.value = 'No aceptable';
    }
    else if(nivelRiesgo.value >=  150  && nivelRiesgo.value <= 500)
    {
    	nombreRiesgo.value = 'II';
        aceptacionRiesgo.value = 'No aceptable o aceptable con control específico';
    }
    else if(nivelRiesgo.value >=  40  && nivelRiesgo.value <= 120)
    {
    	nombreRiesgo.value = 'III';
        aceptacionRiesgo.value = 'Aceptable';
    }
    else if(nivelRiesgo.value ==  20)
    {
    	nombreRiesgo.value = 'IV';
        aceptacionRiesgo.value = 'Aceptable';
    }
    else if(nivelRiesgo.value ==  0)
    {
    	nombreRiesgo.value = '';
        aceptacionRiesgo.value = '';												
	}
}

function calcularExpuestos(registro)
{
    var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
    
    var campos = document.querySelectorAll(" div#detalle_"+posicion+"  input[name='vinculadosMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='temporalesMatrizRiesgoDetalle[]'], div#detalle_"+posicion+" input[name='totalExpuestosMatrizRiesgoDetalle[]']");

    var vinculados = campos[0];
    var temporales = campos[1];
    var total = campos[2];

    total.value = parseFloat(vinculados.value) + parseFloat(temporales.value); 
}

$("#Grabar").click(function(){
    var route = "http://localhost:8000/matrizriesgo";
    var token = $("#token").val();

    $.ajax({
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        
        success:function(){
            $("#msj-success").fadeIn();
        },

        /*error:function(msj){
            $("#msj").html(msj.responseJSON);
            $("#msj-error").fadeIn();
        }*/        
    });

});