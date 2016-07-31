function validarFormulario(event)
{
    var route = "http://"+location.host+"/planauditoria";
    var token = $("#token").val();
    var dato0 = document.getElementById('idPlanAuditoria').value;
    var dato1 = document.getElementById('numeroPlanAuditoria').value;
    var dato2 = document.getElementById('fechaInicioPlanAuditoria').value;
    var dato3 = document.getElementById('fechaFinPlanAuditoria').value;
    var dato4 = document.getElementById('Tercero_AuditorLider').value;
    var datoAcompañante = document.querySelectorAll("[name='Tercero_idAcompanante[]']");
    var datoNotificado = document.querySelectorAll("[name='Tercero_idNotificado[]']");
    var datoProceso = document.querySelectorAll("[name='Proceso_idProceso[]']");
    var datoAuditado = document.querySelectorAll("[name='Tercero_Auditado[]']");
    var datoAuditor = document.querySelectorAll("[name='Tercero_Auditor[]']");
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    var dato8 = [];
    var dato9 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoAcompañante.length; j<i;j++)
    {
        dato5[j] = datoAcompañante[j].value;
    }

    for(var j=0,i=datoNotificado.length; j<i;j++)
    {
        dato6[j] = datoNotificado[j].value;
    }

    for(var j=0,i=datoProceso.length; j<i;j++)
    {
        dato7[j] = datoProceso[j].value;
    }

    for(var j=0,i=datoAuditado.length; j<i;j++)
    {
        dato8[j] = datoAuditado[j].value;
    }

    for(var j=0,i=datoAuditor.length; j<i;j++)
    {
        dato9[j] = datoAuditor[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idPlanAuditoria: dato0,
                numeroPlanAuditoria: dato1,
                fechaInicioPlanAuditoria: dato2,
                fechaFinPlanAuditoria: dato3,
                Tercero_AuditorLider: dato4, 
                Tercero_idAcompanante: dato5, 
                Tercero_idNotificado: dato6, 
                Proceso_idProceso: dato7,
                Tercero_Auditado: dato8,
                Tercero_Auditor: dato9
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

                (typeof msj.responseJSON.numeroPlanAuditoria === "undefined" ? document.getElementById('numeroPlanAuditoria').style.borderColor = '' : document.getElementById('numeroPlanAuditoria').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaInicioPlanAuditoria === "undefined" ? document.getElementById('fechaInicioPlanAuditoria').style.borderColor = '' : document.getElementById('fechaInicioPlanAuditoria').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaFinPlanAuditoria === "undefined" ? document.getElementById('fechaFinPlanAuditoria').style.borderColor = '' : document.getElementById('fechaFinPlanAuditoria').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_AuditorLider === "undefined" ? document.getElementById('Tercero_AuditorLider').style.borderColor = '' : document.getElementById('Tercero_AuditorLider').style.borderColor = '#a94442');

                for(var j=0,i=datoAcompañante.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idAcompanante'+j] === "undefined" 
                        ? document.getElementById('Tercero_idAcompanante'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idAcompanante'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoNotificado.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idNotificado'+j] === "undefined" ? document.getElementById('Tercero_idNotificado'+j).style.borderColor = '' : document.getElementById('Tercero_idNotificado'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoProceso.length; j<i;j++)
                {
                    (typeof respuesta['Proceso_idProceso'+j] === "undefined" ? document.getElementById('Proceso_idProceso'+j).style.borderColor = '' : document.getElementById('Proceso_idProceso'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoAuditado.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_Auditado'+j] === "undefined" ? document.getElementById('Tercero_Auditado'+j).style.borderColor = '' : document.getElementById('Tercero_Auditado'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoAuditor.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_Auditor'+j] === "undefined" ? document.getElementById('Tercero_Auditor'+j).style.borderColor = '' : document.getElementById('Tercero_Auditor'+j).style.borderColor = '#a94442');
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

