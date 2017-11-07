function validarFormulario(event)
{
    var route = "http://"+location.host+"/planemergencia";
    var token = $("#token").val();
    var dato0 = document.getElementById('idPlanEmergencia').value;
    var dato1 = document.getElementById('fechaElaboracionPlanEmergencia').value;
    var dato2 = document.getElementById('nombrePlanEmergencia').value;
    var dato3 = document.getElementById('CentroCosto_idCentroCosto').value;
    var dato4 = document.getElementById('Tercero_idRepresentanteLegal').value;

    // Campos multiregistro Limites
    var planemergenciaSede = document.querySelectorAll("[name='sedePlanEmergenciaLimite[]']");
    var planemergenciaNorte = document.querySelectorAll("[name='nortePlanEmergenciaLimite[]']");
    var planemergenciaSur = document.querySelectorAll("[name='surPlanEmergenciaLimite[]']");
    var planemergenciaOriente = document.querySelectorAll("[name='orientePlanEmergenciaLimite[]']");
    var planemergenciaOccidente = document.querySelectorAll("[name='occidentePlanEmergenciaLimite[]']");
    
    // Campos multiregistro Inventario
    var planemergenciaSedeInventario = document.querySelectorAll("[name='sedePlanEmergenciaInventario[]']");
    var planemergenciaRecursoInventario = document.querySelectorAll("[name='recursoPlanEmergenciaInventario[]']");
    var planemergenciaCantidadInventario = document.querySelectorAll("[name='cantidadPlanEmergenciaInventario[]']");
    var planemergenciaUbicacionInventario = document.querySelectorAll("[name='ubicacionPlanEmergenciaInventario[]']");
    var planemergenciaObservacionInventario = document.querySelectorAll("[name='observacionPlanEmergenciaInventario[]']");

    // Campos multiregistro comité
    var planemergenciaComite = document.querySelectorAll("[name='comitePlanEmergenciaComite[]']");
    var planemergenciaIntegrantes = document.querySelectorAll("[name='integrantesPlanEmergenciaComite[]']");


    // Campos multiregistro NIVEL
    var planemergenciaNivelCargo  = document.querySelectorAll("[name='cargoPlanEmergenciaNivel[]']");


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
    var dato15 = [];
    var dato16 = [];
    var dato17 = [];





   
    var valor = '';
    var sw = true;


   for(var j=0,i= planemergenciaSede.length; j<i;j++)
    {
        dato5[j] = planemergenciaSede[j].value;
    }
     for(var j=0,i= planemergenciaNorte.length; j<i;j++)
    {
        dato6[j] = planemergenciaNorte[j].value;
    }
     for(var j=0,i= planemergenciaSur.length; j<i;j++)
    {
        dato7[j] = planemergenciaSur[j].value;
    }
     for(var j=0,i= planemergenciaOriente.length; j<i;j++)
    {
        dato8[j] = planemergenciaOriente[j].value;
    }
    for(var j=0,i= planemergenciaOccidente.length; j<i;j++)
    {
        dato9[j] = planemergenciaOccidente[j].value;
    }
    for(var j=0,i= planemergenciaSedeInventario.length; j<i;j++)
    {
        dato10[j] = planemergenciaSedeInventario[j].value;
    }
    for(var j=0,i= planemergenciaRecursoInventario.length; j<i;j++)
    {
        dato11[j] = planemergenciaRecursoInventario[j].value;
    }
    for(var j=0,i= planemergenciaCantidadInventario.length; j<i;j++)
    {
        dato12[j] = planemergenciaCantidadInventario[j].value;
    }
    for(var j=0,i= planemergenciaUbicacionInventario.length; j<i;j++)
    {
        dato13[j] = planemergenciaUbicacionInventario[j].value;
    }
    for(var j=0,i= planemergenciaObservacionInventario.length; j<i;j++)
    {
        dato14[j] = planemergenciaObservacionInventario[j].value;
    }
    for(var j=0,i= planemergenciaComite.length; j<i;j++)
    {
        dato15[j] = planemergenciaComite[j].value;
    }
    for(var j=0,i= planemergenciaIntegrantes.length; j<i;j++)
    {
        dato16[j] = planemergenciaIntegrantes[j].value;
    }
     for(var j=0,i= planemergenciaNivelCargo.length; j<i;j++)
    {
        dato17[j] = planemergenciaNivelCargo[j].value;
    }
 

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idPlanEmergencia: dato0,
                fechaElaboracionPlanEmergencia: dato1,
                nombrePlanEmergencia: dato2,
                CentroCosto_idCentroCosto: dato3,
                Tercero_idRepresentanteLegal: dato4,
                sedePlanEmergenciaLimite: dato5,
                nortePlanEmergenciaLimite: dato6,
                surPlanEmergenciaLimite: dato7,
                orientePlanEmergenciaLimite: dato8,
                occidentePlanEmergenciaLimite: dato9,
                sedePlanEmergenciaInventario: dato10,
                recursoPlanEmergenciaInventario: dato11,
                cantidadPlanEmergenciaInventario: dato12,
                ubicacionPlanEmergenciaInventario: dato13,
                observacionPlanEmergenciaInventario: dato14,
                comitePlanEmergenciaComite: dato15,
                integrantesPlanEmergenciaComite: dato16,
                cargoPlanEmergenciaNivel: dato17
 
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
               
                (typeof msj.responseJSON.fechaElaboracionPlanEmergencia === "undefined" ? document.getElementById('fechaElaboracionPlanEmergencia').style.borderColor = '' : document.getElementById('fechaElaboracionPlanEmergencia').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombrePlanEmergencia === "undefined" ? document.getElementById('nombrePlanEmergencia').style.borderColor = '' : document.getElementById('nombrePlanEmergencia').style.borderColor = '#a94442');

                (typeof msj.responseJSON.CentroCosto_idCentroCosto === "undefined" ? document.getElementById('CentroCosto_idCentroCosto').style.borderColor = '' : document.getElementById('CentroCosto_idCentroCosto').style.borderColor = '#a94442');
               
                (typeof msj.responseJSON.Tercero_idRepresentanteLegal === "undefined" ? document.getElementById('Tercero_idRepresentanteLegal').style.borderColor = '' : document.getElementById('Tercero_idRepresentanteLegal').style.borderColor = '#a94442');
                
                for(var j=0,i=planemergenciaSede.length; j<i;j++)
                {
                    (typeof respuesta['sedePlanEmergenciaLimite'+j] === "undefined" 
                        ? document.getElementById('sedePlanEmergenciaLimite'+j).style.borderColor = '' 
                        : document.getElementById('sedePlanEmergenciaLimite'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=planemergenciaNorte.length; j<i;j++)
                {
                    (typeof respuesta['nortePlanEmergenciaLimite'+j] === "undefined" 
                        ? document.getElementById('nortePlanEmergenciaLimite'+j).style.borderColor = '' 
                        : document.getElementById('nortePlanEmergenciaLimite'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=planemergenciaSur.length; j<i;j++)
                {
                    (typeof respuesta['surPlanEmergenciaLimite'+j] === "undefined" 
                        ? document.getElementById('surPlanEmergenciaLimite'+j).style.borderColor = '' 
                        : document.getElementById('surPlanEmergenciaLimite'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=planemergenciaOriente.length; j<i;j++)
                {
                    (typeof respuesta['orientePlanEmergenciaLimite'+j] === "undefined" 
                        ? document.getElementById('orientePlanEmergenciaLimite'+j).style.borderColor = '' 
                        : document.getElementById('orientePlanEmergenciaLimite'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=planemergenciaOccidente.length; j<i;j++)
                {
                    (typeof respuesta['occidentePlanEmergenciaLimite'+j] === "undefined" 
                        ? document.getElementById('occidentePlanEmergenciaLimite'+j).style.borderColor = '' 
                        : document.getElementById('occidentePlanEmergenciaLimite'+j).style.borderColor = '#a94442');
                }
                 for(var j=0,i=planemergenciaSedeInventario.length; j<i;j++)
                {
                    (typeof respuesta['sedePlanEmergenciaInventario'+j] === "undefined" 
                        ? document.getElementById('sedePlanEmergenciaInventario'+j).style.borderColor = '' 
                        : document.getElementById('sedePlanEmergenciaInventario'+j).style.borderColor = '#a94442');
                }
                 for(var j=0,i=planemergenciaRecursoInventario.length; j<i;j++)
                {
                    (typeof respuesta['recursoPlanEmergenciaInventario'+j] === "undefined" 
                        ? document.getElementById('recursoPlanEmergenciaInventario'+j).style.borderColor = '' 
                        : document.getElementById('recursoPlanEmergenciaInventario'+j).style.borderColor = '#a94442');
                }
                 for(var j=0,i=planemergenciaCantidadInventario.length; j<i;j++)
                {
                    (typeof respuesta['cantidadPlanEmergenciaInventario'+j] === "undefined" 
                        ? document.getElementById('cantidadPlanEmergenciaInventario'+j).style.borderColor = '' 
                        : document.getElementById('cantidadPlanEmergenciaInventario'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=planemergenciaUbicacionInventario.length; j<i;j++)
                {
                    (typeof respuesta['ubicacionPlanEmergenciaInventario'+j] === "undefined" 
                        ? document.getElementById('ubicacionPlanEmergenciaInventario'+j).style.borderColor = '' 
                        : document.getElementById('ubicacionPlanEmergenciaInventario'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=planemergenciaObservacionInventario.length; j<i;j++)
                {
                    (typeof respuesta['observacionPlanEmergenciaInventario'+j] === "undefined" 
                        ? document.getElementById('observacionPlanEmergenciaInventario'+j).style.borderColor = '' 
                        : document.getElementById('observacionPlanEmergenciaInventario'+j).style.borderColor = '#a94442');
                }

                  for(var j=0,i=planemergenciaComite.length; j<i;j++)
                {
                    (typeof respuesta['comitePlanEmergenciaComite'+j] === "undefined" 
                        ? document.getElementById('comitePlanEmergenciaComite'+j).style.borderColor = '' 
                        : document.getElementById('comitePlanEmergenciaComite'+j).style.borderColor = '#a94442');
                }

                  for(var j=0,i=planemergenciaIntegrantes.length; j<i;j++)
                {
                    (typeof respuesta['integrantesPlanEmergenciaComite'+j] === "undefined" 
                        ? document.getElementById('integrantesPlanEmergenciaComite'+j).style.borderColor = '' 
                        : document.getElementById('integrantesPlanEmergenciaComite'+j).style.borderColor = '#a94442');
                }

                  for(var j=0,i=planemergenciaNivelCargo.length; j<i;j++)
                {
                    (typeof respuesta['cargoPlanEmergenciaNivel'+j] === "undefined" 
                        ? document.getElementById('cargoPlanEmergenciaNivel'+j).style.borderColor = '' 
                        : document.getElementById('cargoPlanEmergenciaNivel'+j).style.borderColor = '#a94442');
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

