function validarFormulario(event)
{
    var route = "http://"+location.host+"/reporteacpm";
    var token = $("#token").val();
    var dato0 = document.getElementById('idReporteACPM').value;
    var dato1 = document.getElementById('fechaElaboracionReporteACPM').value;


    var datoProceso = document.querySelectorAll("[name='Proceso_idProceso[]']");
    var datoModulo = document.querySelectorAll("[name='Modulo_idModulo[]']");
    var tipoReporte = document.querySelectorAll("[name='tipoReporteACPMDetalle[]']");

    var dato2 = [];
    var dato3 = [];
    var dato4 = [];
    var dato5 = document.getElementById('numeroReporteACPM').value;
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoProceso.length; j<i;j++)
    {
        dato2[j] = datoProceso[j].value;
    }

    for(var j=0,i=datoModulo.length; j<i;j++)
    {
        dato3[j] = datoModulo[j].value;
    }

    for(var j=0,i=tipoReporte.length; j<i;j++)
    {
        dato4[j] = tipoReporte[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idReporteACPM: dato0,
                fechaElaboracionReporteACPM: dato1,
                Proceso_idProceso: dato2,
                Modulo_idModulo: dato3,
                tipoReporteACPMDetalle: dato4, 
                numeroReporteACPM: dato5,
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

                (typeof msj.responseJSON.fechaElaboracionReporteACPM === "undefined" ? document.getElementById('fechaElaboracionReporteACPM').style.borderColor = '' : document.getElementById('fechaElaboracionReporteACPM').style.borderColor = '#a94442');

                (typeof msj.responseJSON.numeroReporteACPM === "undefined" ? document.getElementById('numeroReporteACPM').style.borderColor = '' : document.getElementById('numeroReporteACPM').style.borderColor = '#a94442');

                for(var j=0,i=datoProceso.length; j<i;j++)
                {
                    (typeof respuesta['Proceso_idProceso'+j] === "undefined" ? document.getElementById('Proceso_idProceso'+j).style.borderColor = '' : document.getElementById('Proceso_idProceso'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoModulo.length; j<i;j++)
                {
                    (typeof respuesta['Modulo_idModulo'+j] === "undefined" ? document.getElementById('Modulo_idModulo'+j).style.borderColor = '' : document.getElementById('Modulo_idModulo'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=tipoReporte.length; j<i;j++)
                {
                    (typeof respuesta['tipoReporteACPMDetalle'+j] === "undefined" ? document.getElementById('tipoReporteACPMDetalle'+j).style.borderColor = '' : document.getElementById('tipoReporteACPMDetalle'+j).style.borderColor = '#a94442');
                }

                var mensaje = 'Por favor verifique los siguientes valores <br><ul>';
                $.each(respuesta,function(index, value){
                    mensaje +='<li>' +value+'</li><br>';
                });
                mensaje +='</ul>';
               
                $("#msj").html(mensaje);
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}




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