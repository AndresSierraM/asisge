// function habilitarSubmit(event)
// {
//     event.preventDefault();
    

//     validarformulario();
// }


function eliminarArchivo(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarArchivo").val( $("#eliminarArchivo").val() + idDiv + ",");  
    }
}

function validarformulario(event)
{
    var route = "http://"+location.host+"/programa";
    var token = $("#token").val();
    var dato0 = document.getElementById('idPrograma').value;
    var dato1 = document.getElementById('nombrePrograma').value;
    var dato2 = document.getElementById('fechaElaboracionPrograma').value;
    var dato3 = document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo').value;
    var dato4 = document.getElementById('CompaniaObjetivo_idCompaniaObjetivo').value;
    var dato5 = document.getElementById('Tercero_idElabora').value;
    var datoResponsable = document.querySelectorAll("[name='Tercero_idResponsable[]']");
    var datoDocumento = document.querySelectorAll("[name='Documento_idDocumento[]']");
    var datoActividades = document.querySelectorAll("[name='actividadProgramaDetalle[]']");
    var dato6 = [];
    var dato7 = [];
    var dato8 = [];
    
    var valor = '';
    var sw = true;

    for(var j=0,i=datoResponsable.length; j<i;j++)
    {
        dato6[j] = datoResponsable[j].value;
    }

    for(var j=0,i=datoDocumento.length; j<i;j++)
    {
        dato7[j] = datoDocumento[j].value;
    }

    for(var j=0,i=datoActividades.length; j<i;j++)
    {
        dato8[j] = datoActividades[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idPrograma: dato0,
                nombrePrograma: dato1,
                fechaElaboracionPrograma: dato2,
                ClasificacionRiesgo_idClasificacionRiesgo: dato3,
                CompaniaObjetivo_idCompaniaObjetivo: dato4, 
                Tercero_idElabora: dato5, 
                Tercero_idResponsable: dato6,
                Documento_idDocumento: dato7,
                actividadProgramaDetalle: dato8

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

                (typeof msj.responseJSON.nombrePrograma === "undefined" ? document.getElementById('nombrePrograma').style.borderColor = '' : document.getElementById('nombrePrograma').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionPrograma === "undefined" ? document.getElementById('fechaElaboracionPrograma').style.borderColor = '' : document.getElementById('fechaElaboracionPrograma').style.borderColor = '#a94442');

                (typeof msj.responseJSON.ClasificacionRiesgo_idClasificacionRiesgo === "ClasificacionRiesgo_idClasificacionRiesgo" ? document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo').style.borderColor = '' : document.getElementById('ClasificacionRiesgo_idClasificacionRiesgo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.CompaniaObjetivo_idCompaniaObjetivo === "CompaniaObjetivo_idCompaniaObjetivo" ? document.getElementById('CompaniaObjetivo_idCompaniaObjetivo').style.borderColor = '' : document.getElementById('CompaniaObjetivo_idCompaniaObjetivo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idElabora === "Tercero_idElabora" ? document.getElementById('Tercero_idElabora').style.borderColor = '' : document.getElementById('Tercero_idElabora').style.borderColor = '#a94442');
                
                for(var j=0,i=datoResponsable.length; j<i;j++)
                {
                    (typeof respuesta['Tercero_idResponsable'+j] === "undefined" 
                        ? document.getElementById('Tercero_idResponsable'+j).style.borderColor = '' 
                        : document.getElementById('Tercero_idResponsable'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoDocumento.length; j<i;j++)
                {
                    (typeof respuesta['Documento_idDocumento'+j] === "undefined" ? document.getElementById('Documento_idDocumento'+j).style.borderColor = '' : document.getElementById('Documento_idDocumento'+j).style.borderColor = '#a94442');
                }


                for(var j=0,i=datoActividades.length; j<i;j++)
                {
                    (typeof respuesta['actividadProgramaDetalle'+j] === "undefined" 
                        ? document.getElementById('actividadProgramaDetalle'+j).style.borderColor = '' 
                        : document.getElementById('actividadProgramaDetalle'+j).style.borderColor = '#a94442');
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