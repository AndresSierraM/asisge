function calcularDiasAusencia(fechaIni, fechaFin)
{
	var fecha1 = new   Date(fechaIni.substring(0,4),fechaIni.substring(5,7)-1,fechaIni.substring(8,10));
	var fecha2 = new Date(fechaFin.substring(0,4),fechaFin.substring(5,7)-1,fechaFin.substring(8,10));
	var diasDif = fecha2.getTime() - fecha1.getTime();
	var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));

	calcularTiempoDosFechas(fechaIni, fechaFin);
    document.getElementById('diasAusentismo').value =  dias+1;

}


function calcularTiempoDosFechas(dato1, dato2){
	
	// Se valida que las dos fecha si tengan valor para que no haga calculos sin ambas fechas 
	if ($("#fechaInicioAusentismo").val() == ''|| ($("#fechaFinAusentismo").val() == ''))
	{
		$("#horasAusentismo").val(0);
	}
	else
	{
		// Tomamos los dos valores enviados desde el formulario en la funcion de calcularDiasAusencia
	// Se crean nos nuevos datos con las dos fechas 
    fecha1 = new Date(dato1);

    fecha2 = new Date(dato2);
    // Se crea una variable que le va a restar la diferencia 
    var diff = fecha2 - fecha1;
    // luego una variable que va contener los segundos de diferencia entre las fechas 
    var diffSegundos = diff/1000;
    // Luego variable para Hora 3600 segundos  es 1 hora
    var HH = Math.floor(diffSegundos/3600);
     // Luego se crea la variable para minutos
    var MM = Math.floor(diffSegundos%3600)/60;
    
	//se hace una condicion para que quede  numericamente es decir:
	// 1 hora 30 minutos =  1.5
	// 30 minutos = 0.5

    var final = HH + (MM / 60);


   
    // La variable formateado sirve para cuando se quiere un calculo , hora,minuto,segundo,milisegundo 
    // var formateado = ((HH < 10)?("0" + HH):HH) + ":" + ((MM < 10)?("0" + MM):MM)

  

    $("#horasAusentismo").val(final);
	}

	


}

