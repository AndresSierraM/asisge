function validarFormulario(event)
{
    var route = "http://"+location.host+"/listachequeo";
    var token = $("#token").val();
    var dato0 = document.getElementById('idListaChequeo').value;
    var dato1 = document.getElementById('numeroListaChequeo').value;
    var dato2 = document.getElementById('fechaElaboracionListaChequeo').value;
    var dato3 = document.getElementById('PlanAuditoria_idPlanAuditoria').value;
    var dato4 = document.getElementById('Proceso_idProceso').value;
    var datoTercero = document.querySelectorAll("[name='Tercero_idTercero[]']");
    var dato5 = [];

    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoTercero.length; j<i;j++)
    {
        dato5[j] = datoTercero[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idListaChequeo: dato0,
                numeroListaChequeo: dato1,
                fechaElaboracionListaChequeo: dato2,
                PlanAuditoria_idPlanAuditoria: dato3,
                Proceso_idProceso: dato4, 
                Tercero_idTercero: dato5
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

                (typeof msj.responseJSON.numeroListaChequeo === "undefined" ? document.getElementById('numeroListaChequeo').style.borderColor = '' : document.getElementById('numeroListaChequeo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionListaChequeo === "undefined" ? document.getElementById('fechaElaboracionListaChequeo').style.borderColor = '' : document.getElementById('fechaElaboracionListaChequeo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.PlanAuditoria_idPlanAuditoria === "undefined" ? document.getElementById('PlanAuditoria_idPlanAuditoria').style.borderColor = '' : document.getElementById('PlanAuditoria_idPlanAuditoria').style.borderColor = '#a94442');
      
      			(typeof msj.responseJSON.Proceso_idProceso === "undefined" ? document.getElementById('Proceso_idProceso').style.borderColor = '' : document.getElementById('Proceso_idProceso').style.borderColor = '#a94442');

                for(var j=0,i=datoTercero.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idTercero'+j] === "undefined" 
                        ? document.getElementById('Tercero_idTercero'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idTercero'+j).style.borderColor = '#a94442');
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



function buscarProceso(){

	var dato = document.getElementById('PlanAuditoria_idPlanAuditoria').value;
	var token = document.getElementById('token').value;
	var id = (document.getElementById('idListaChequeo').value == '' ? 0 : document.getElementById('idListaChequeo').value);

	$.ajax({
		async: true,
		headers: {'X-CSRF-TOKEN': token},
		url: 'http://'+location.host+'/listachequeo/'+id,
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

