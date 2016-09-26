function buscarTipoRiesgo(registro){

	var posicion = registro.length > 0 ? registro.substring(registro.indexOf('_') + 1) : '';
	var dato = document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo'+posicion).value;
	var token = document.getElementById('token').value;
	var id = document.getElementById('idMatrizRiesgoDetalle'+posicion).value;

	$.ajax({
		async: true,
		headers: {'X-CSRF-TOKEN': token},
		url: 'http://'+location.host+'/matrizriesgo/'+id,
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
		url: 'http://'+location.host+'/matrizriesgo/'+id,
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
    
    var campos = document.querySelectorAll(
        " div#detalle_"+posicion+"  select[name='nivelDeficienciaMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" select[name='nivelExposicionMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" input[name='nivelProbabilidadMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" input[name='nombreProbabilidadMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" select[name='nivelConsecuenciaMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" input[name='nivelRiesgoMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" input[name='nombreRiesgoMatrizRiesgoDetalle[]'], "+
        " div#detalle_"+posicion+" input[name='aceptacionRiesgoMatrizRiesgoDetalle[]']");
    
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



function validarFormulario(event)
{
    var route = "http://"+location.host+"/matrizriesgo";
    var token = $("#token").val();
    var dato1 = document.getElementById('nombreMatrizRiesgo').value;
    var dato2 = document.getElementById('fechaElaboracionMatrizRiesgo').value;
    var datoProceso = document.querySelectorAll("[name='Proceso_idProceso[]']");
    var datoClasificacion = document.querySelectorAll("[name='ClasificacionRiesgo_idClasificacionRiesgo[]']");
    var datoRiesgo = document.querySelectorAll("[name='TipoRiesgo_idTipoRiesgo[]']");
    var datoDetalle = document.querySelectorAll("[name='TipoRiesgoDetalle_idTipoRiesgoDetalle[]']");
    var datoSalud = document.querySelectorAll("[name='TipoRiesgoSalud_idTipoRiesgoSalud[]']");
    var datoEliminacion = document.querySelectorAll("[name='eliminacionMatrizRiesgoDetalle[]']");
    var datoSustitucion = document.querySelectorAll("[name='sustitucionMatrizRiesgoDetalle[]']");
    var datoControl = document.querySelectorAll("[name='controlMatrizRiesgoDetalle[]']");
    var datoElemento = document.querySelectorAll("[name='elementoProteccionMatrizRiesgoDetalle[]']");
    var datoDeficiencia= document.querySelectorAll("[name='nivelDeficienciaMatrizRiesgoDetalle[]']");
    var datoExposicion = document.querySelectorAll("[name='nivelExposicionMatrizRiesgoDetalle[]']");
    var datoConsecuencia = document.querySelectorAll("[name='nivelConsecuenciaMatrizRiesgoDetalle[]']");
    var dato3 = [];
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    var dato8 = [];
    var dato9 = [];
    var dato10 = [];
    var dato11 = [];
    var dato12 = [];
    var dato13 = [];
    var dato14 = [];
    var dato15 = document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').value;
    
    var valor = '';
    var sw = true;
    for(var j=0,i=datoProceso.length; j<i;j++)
    {
        dato3[j] = datoProceso[j].value;
        dato4[j] = datoClasificacion[j].value;
        dato5[j] = datoDetalle[j].value;
        dato6[j] = datoSalud[j].value;
        dato7[j] = datoEliminacion[j].value;
        dato8[j] = datoSustitucion[j].value;
        dato9[j] = datoControl[j].value;
        dato10[j] = datoElemento[j].value;
        dato11[j] = datoRiesgo[j].value;
        dato12[j] = datoDeficiencia[j].value;
        dato13[j] = datoExposicion[j].value;
        dato14[j] = datoConsecuencia[j].value;
        dato14[j] = datoConsecuencia[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                nombreMatrizRiesgo: dato1,
                fechaElaboracionMatrizRiesgo: dato2,
                Proceso_idProceso: dato3,
                ClasificacionRiesgo_idClasificacionRiesgo: dato4, 
                TipoRiesgoDetalle_idTipoRiesgoDetalle: dato5, 
                TipoRiesgoSalud_idTipoRiesgoSalud: dato6, 
                eliminacionMatrizRiesgoDetalle: dato7, 
                sustitucionMatrizRiesgoDetalle: dato8, 
                controlMatrizRiesgoDetalle: dato9, 
                elementoProteccionMatrizRiesgoDetalle: dato10, 
                TipoRiesgo_idTipoRiesgo: dato11,
                nivelDeficienciaMatrizRiesgoDetalle: dato12,
                nivelExposicionMatrizRiesgoDetalle: dato13,
                nivelConsecuenciaMatrizRiesgoDetalle: dato14,
                FrecuenciaMedicion_idFrecuenciaMedicion: dato15
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
                $("#Grabar").click();
            }
            else
            {
                sw = true;
                respuesta = JSON.parse(respuesta);


                (typeof msj.responseJSON.nombreMatrizRiesgo === "undefined" ? document.getElementById('nombreMatrizRiesgo').style.borderColor = '' : document.getElementById('nombreMatrizRiesgo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionMatrizRiesgo === "undefined" ? document.getElementById('fechaElaboracionMatrizRiesgo').style.borderColor = '' : document.getElementById('fechaElaboracionMatrizRiesgo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.FrecuenciaMedicion_idFrecuenciaMedicion === "undefined" ? document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').style.borderColor = '' : document.getElementById('FrecuenciaMedicion_idFrecuenciaMedicion').style.borderColor = '#a94442');

                for(var j=0,i=datoProceso.length; j<i;j++)
                {
                    (typeof respuesta['Proceso_idProceso'+j] === "undefined" ? document.getElementById('Proceso_idProceso'+j).style.borderColor = '' : document.getElementById('Proceso_idProceso'+j).style.borderColor = '#a94442');

                    (typeof respuesta['ClasificacionRiesgo_idClasificacionRiesgo'+j] === "undefined" ? document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo'+j).style.borderColor = '' : document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo'+j).style.borderColor = '#a94442');

                    (typeof respuesta['TipoRiesgoDetalle_idTipoRiesgoDetalle'+j] === "undefined" ? document.getElementById('TipoRiesgoDetalle_idTipoRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('TipoRiesgoDetalle_idTipoRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['TipoRiesgoSalud_idTipoRiesgoSalud'+j] === "undefined" ? document.getElementById('TipoRiesgoSalud_idTipoRiesgoSalud'+j).style.borderColor = '' : document.getElementById('TipoRiesgoSalud_idTipoRiesgoSalud'+j).style.borderColor = '#a94442');

                    (typeof respuesta['TipoRiesgo_idTipoRiesgo'+j] === "undefined" ? document.getElementById('TipoRiesgo_idTipoRiesgo'+j).style.borderColor = '' : document.getElementById('TipoRiesgo_idTipoRiesgo'+j).style.borderColor = '#a94442');

                    (typeof respuesta['eliminacionMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('eliminacionMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('eliminacionMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['sustitucionMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('sustitucionMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('sustitucionMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['controlMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('controlMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('controlMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['elementoProteccionMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('elementoProteccionMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('elementoProteccionMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['nivelDeficienciaMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('nivelDeficienciaMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('nivelDeficienciaMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['nivelExposicionMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('nivelExposicionMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('nivelExposicionMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                    (typeof respuesta['nivelConsecuenciaMatrizRiesgoDetalle'+j] === "undefined" ? document.getElementById('nivelConsecuenciaMatrizRiesgoDetalle'+j).style.borderColor = '' : document.getElementById('nivelConsecuenciaMatrizRiesgoDetalle'+j).style.borderColor = '#a94442');

                }
                $("#msj").html('Los campos bordeados en rojo son obligatorios.');
                $("#msj-error").fadeIn();
            }

        }
    });

    if(sw === true)
        event.preventDefault();
}

function ejecutarInterface(ruta)
{
    var token = document.getElementById('token').value;
    $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            url:   'http://'+location.host+'/importarMatrizRiesgo',
            type:  'post',
            beforeSend: function(){
                
                },
            success: function(respuesta)
            {
                if(respuesta[0] == true)
                {
                    alert(respuesta[1]);
                    $("#modalMatrizRiesgo").modal("hide");
                }
                else
                {
                    $("#reporteErrorMatrizRiesgo").html(respuesta[1]);
                    $("#ModalErroresMatrizRiesgo").modal("show");
                }
            },
            error: function(xhr,err)
            { 
                console.log(err);
                alert("Error "+err);
            }
        });
    $("#dropzoneMatrizRiesgoArchivo .dz-preview").remove();
    $("#dropzoneMatrizRiesgoArchivo .dz-message").html('Seleccione o arrastre los archivos a subir.');
}