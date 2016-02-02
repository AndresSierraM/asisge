function restarFechas(registro, tipo){

	
	var posicion;
	if(tipo == 'A')
		posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	else
		posicion = registro;
	
	var campos = document.querySelectorAll(" div#detalle_"+posicion+" input[name='fechaEstimadaCierreReporteACPMDetalle[]'], div#detalle_"+posicion+" input[name='fechaCierreReporteACPMDetalle[]'], div#detalle_"+posicion+" input[name='diasAtrasoReporteACPMDetalle[]']");
	
	var fecha1 = campos[0].value;
    var fecha2 = campos[1].value;
    var diferencia = campos[2];

	var dia1= fecha1.substr(8,2);
	var mes1= fecha1.substr(5,2);
	var ano1= fecha1.substr(0,4);

	var dia2= fecha2.substr(8,2);
	var mes2= fecha2.substr(5,2);
	var ano2= fecha2.substr(0,4);

	var nuevafecha1 = new Date(ano1+","+mes1+","+dia1);
	var nuevafecha2 = new Date(ano2+","+mes2+","+dia2);

	var Dif= nuevafecha2.getTime() - nuevafecha1.getTime();
	var dias = Math.floor(Dif/(1000*24*60*60));
	diferencia.value = dias;
}

function fechaReporte(registro)
{
	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	$('#fechaReporteACPMDetalle'+posicion).datetimepicker(({
		format: "YYYY-MM-DD"
	}));
}

function fechaEstimadaCierre(registro)
{
	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	$('#fechaEstimadaCierreReporteACPMDetalle'+posicion).datetimepicker(({
		format: "YYYY-MM-DD"
	}));
}

function fechaCierre(registro)
{
	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	$('#fechaCierreReporteACPMDetalle'+posicion).datetimepicker(({
		format: "YYYY-MM-DD"
	}));
}