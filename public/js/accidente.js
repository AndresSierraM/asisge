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

function validarFormulario(event)
{
    var route = "http://"+location.host+"/accidente";
    var token = $("#token").val();
    var dato0 = document.getElementById('idAccidente').value;
    var dato1 = document.getElementById('Tercero_idCoordinador').value;
    var dato2 = document.getElementById('nombreAccidente').value;
    var dato3 = document.getElementById('fechaOcurrenciaAccidente').value;
    var dato4 = document.getElementById('clasificacionAccidente').value;
    var dato5 = document.getElementById('Tercero_idEmpleado').value;
    var dato6 = document.getElementById('Ausentismo_idAusentismo').value;
    var dato7 = document.getElementById('Proceso_idProceso').value;
    var datoResponsable = document.querySelectorAll("[name='Proceso_idResponsable[]']");
    var datoInvestigador = document.querySelectorAll("[name='Tercero_idInvestigador[]']");
    var dato8 = [];
    var dato9 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoResponsable.length; j<i;j++)
    {
        dato8[j] = datoResponsable[j].value;
    }

    for(var j=0,i=datoInvestigador.length; j<i;j++)
    {
        dato9[j] = datoInvestigador[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idAccidente: dato0,
                Tercero_idCoordinador: dato1,
                nombreAccidente: dato2,
                fechaOcurrenciaAccidente: dato3,
                clasificacionAccidente: dato4, 
                Tercero_idEmpleado: dato5, 
                Ausentismo_idAusentismo: dato6, 
                Proceso_idProceso: dato7,
                Proceso_idResponsable: dato8,
                Tercero_idInvestigador: dato9,
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

                (typeof msj.responseJSON.Tercero_idCoordinador === "undefined" ? document.getElementById('Tercero_idCoordinador').style.borderColor = '' : document.getElementById('Tercero_idCoordinador').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreAccidente === "undefined" ? document.getElementById('nombreAccidente').style.borderColor = '' : document.getElementById('nombreAccidente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaOcurrenciaAccidente === "undefined" ? document.getElementById('fechaOcurrenciaAccidente').style.borderColor = '' : document.getElementById('fechaOcurrenciaAccidente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.clasificacionAccidente === "undefined" ? document.getElementById('clasificacionAccidente').style.borderColor = '' : document.getElementById('clasificacionAccidente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idEmpleado === "undefined" ? document.getElementById('Tercero_idEmpleado').style.borderColor = '' : document.getElementById('Tercero_idEmpleado').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Ausentismo_idAusentismo === "undefined" ? document.getElementById('Ausentismo_idAusentismo').style.borderColor = '' : document.getElementById('Ausentismo_idAusentismo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Proceso_idProceso === "undefined" ? document.getElementById('Proceso_idProceso').style.borderColor = '' : document.getElementById('Proceso_idProceso').style.borderColor = '#a94442');


                for(var j=0,i=datoResponsable.length; j<i;j++)
                {
                    (typeof respuesta['Proceso_idResponsable'+j] === "undefined" 
                        ? document.getElementById('Proceso_idResponsable'+j).style.borderColor = '' 
                        : document.getElementById('Proceso_idResponsable'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoInvestigador.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idInvestigador'+j] === "undefined" ? document.getElementById('Tercero_idInvestigador'+j).style.borderColor = '' : document.getElementById('Tercero_idInvestigador'+j).style.borderColor = '#a94442');
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


