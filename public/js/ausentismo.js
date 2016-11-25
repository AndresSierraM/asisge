function calcularDiasAusencia(fechaIni, fechaFin)
{
	var fecha1 = new   Date(fechaIni.substring(0,4),fechaIni.substring(5,7)-1,fechaIni.substring(8,10));
	var fecha2 = new Date(fechaFin.substring(0,4),fechaFin.substring(5,7)-1,fechaFin.substring(8,10));
	var diasDif = fecha2.getTime() - fecha1.getTime();
	var dias = Math.round(diasDif/(1000 * 60 * 60 * 24));

    document.getElementById('diasAusentismo').value =  dias+1;

}