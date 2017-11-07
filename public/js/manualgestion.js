// Se hace una funcion para que elimine los archivos que estan subidos en el dropzone y estan siendo mostrados en la preview
function eliminarProceso(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarProceso").val( $("#eliminarProceso").val() + idDiv + ",");  
    }
}


function eliminarEstructura(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarEstructura").val( $("#eliminarEstructura").val() + idDiv + ",");  
    }
}


function eliminarAdjunto(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarAdjunto").val( $("#eliminarAdjunto").val() + idDiv + ",");  
    }
}



function validarFormulario(event)
{
    var route = "http://"+location.host+"/manualgestion";
    var token = $("#token").val();
    var dato0 = document.getElementById('idManualGestion').value;
    var dato1 = document.getElementById('codigoManualGestion').value;
    var dato2 = document.getElementById('nombreManualGestion').value;
    var dato3 = document.getElementById('fechaManualGestion').value;
    var dato4 = document.getElementById('Tercero_idEmpleador').value;

  

    var interesadoManual = document.querySelectorAll("[name='interesadoManualGestionParte[]']");
    var necesidadManual = document.querySelectorAll("[name='necesidadManualGestionParte[]']");
    var cumplimientoManual = document.querySelectorAll("[name='cumplimientoManualGestionParte[]']");
   


    var dato5 = [];
    var dato6 = [];
    var dato7 = [];


   
    var valor = '';
    var sw = true;


   for(var j=0,i= interesadoManual.length; j<i;j++)
    {
        dato5[j] = interesadoManual[j].value;
    }
     for(var j=0,i= necesidadManual.length; j<i;j++)
    {
        dato6[j] = necesidadManual[j].value;
    }
     for(var j=0,i= cumplimientoManual.length; j<i;j++)
    {
        dato7[j] = cumplimientoManual[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idManualGestion: dato0,
                codigoManualGestion: dato1,
                nombreManualGestion: dato2,
                fechaManualGestion: dato3,
                Tercero_idEmpleador: dato4,
                interesadoManualGestionParte: dato5,
                necesidadManualGestionParte: dato6,
                cumplimientoManualGestionParte: dato7,

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
               
                (typeof msj.responseJSON.codigoManualGestion === "undefined" ? document.getElementById('codigoManualGestion').style.borderColor = '' : document.getElementById('codigoManualGestion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreManualGestion === "undefined" ? document.getElementById('nombreManualGestion').style.borderColor = '' : document.getElementById('nombreManualGestion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaManualGestion === "undefined" ? document.getElementById('fechaManualGestion').style.borderColor = '' : document.getElementById('fechaManualGestion').style.borderColor = '#a94442');
               
                (typeof msj.responseJSON.Tercero_idEmpleador === "undefined" ? document.getElementById('Tercero_idEmpleador').style.borderColor = '' : document.getElementById('Tercero_idEmpleador').style.borderColor = '#a94442');
                
                for(var j=0,i=interesadoManual.length; j<i;j++)
                {
                    (typeof respuesta['interesadoManualGestionParte'+j] === "undefined" 
                        ? document.getElementById('interesadoManualGestionParte'+j).style.borderColor = '' 
                        : document.getElementById('interesadoManualGestionParte'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=necesidadManual.length; j<i;j++)
                {
                    (typeof respuesta['necesidadManualGestionParte'+j] === "undefined" 
                        ? document.getElementById('necesidadManualGestionParte'+j).style.borderColor = '' 
                        : document.getElementById('necesidadManualGestionParte'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i=cumplimientoManual.length; j<i;j++)
                {
                    (typeof respuesta['cumplimientoManualGestionParte'+j] === "undefined" 
                        ? document.getElementById('cumplimientoManualGestionParte'+j).style.borderColor = '' 
                        : document.getElementById('cumplimientoManualGestionParte'+j).style.borderColor = '#a94442');
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

