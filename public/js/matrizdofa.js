function validarFormulario(event)
{
    var route = "http://"+location.host+"/matrizdofa";
    var token = $("#token").val();
    var dato0 = document.getElementById('idMatrizDOFA').value;
    var dato1 = document.getElementById('fechaElaboracionMatrizDOFA').value;
    var dato2 = document.getElementById('Tercero_idResponsable').value;
    var dato3 = document.getElementById('Proceso_idProceso').value;
 
 
    var descripcionDofa = document.querySelectorAll("[name='descripcionMatrizDOFADetalle_Oportunidad[]']");
    var descripcionDofaFortaleza = document.querySelectorAll("[name='descripcionMatrizDOFADetalle_Fortaleza[]']");
    var descripcionDofaAmenaza = document.querySelectorAll("[name='descripcionMatrizDOFADetalle_Amenaza[]']");
    var descripcionDofaDebilidad = document.querySelectorAll("[name='descripcionMatrizDOFADetalle_Debilidad[]']");

    
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
   

    
    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= descripcionDofa.length; j<i;j++)
    {
        dato4[j] = descripcionDofa[j].value;
    }
     for(var j=0,i= descripcionDofaFortaleza.length; j<i;j++)
    {
        dato5[j] = descripcionDofaFortaleza[j].value;
    }
     for(var j=0,i= descripcionDofaAmenaza.length; j<i;j++)
    {
        dato6[j] = descripcionDofaAmenaza[j].value;
    }
     for(var j=0,i= descripcionDofaDebilidad.length; j<i;j++)
    {
        dato7[j] = descripcionDofaDebilidad[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idMatrizDOFA: dato0,
                fechaElaboracionMatrizDOFA: dato1,
                Tercero_idResponsable: dato2,
                Proceso_idProceso: dato3,
                descripcionMatrizDOFADetalle_Oportunidad: dato4,
                descripcionMatrizDOFADetalle_Fortaleza: dato5, 
                descripcionMatrizDOFADetalle_Amenaza: dato6, 
                descripcionMatrizDOFADetalle_Debilidad: dato7, 
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
               
                (typeof msj.responseJSON.fechaElaboracionMatrizDOFA === "undefined" ? document.getElementById('fechaElaboracionMatrizDOFA').style.borderColor = '' : document.getElementById('fechaElaboracionMatrizDOFA').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idResponsable === "undefined" ? document.getElementById('Tercero_idResponsable').style.borderColor = '' : document.getElementById('Tercero_idResponsable').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Proceso_idProceso === "undefined" ? document.getElementById('Proceso_idProceso').style.borderColor = '' : document.getElementById('Proceso_idProceso').style.borderColor = '#a94442');
               

         
                for(var j=0,i=descripcionDofa.length; j<i;j++)
                {
                    (typeof respuesta['descripcionMatrizDOFADetalle_Oportunidad'+j] === "undefined" 
                        ? document.getElementById('descripcionMatrizDOFADetalle_Oportunidad'+j).style.borderColor = '' 
                        : document.getElementById('descripcionMatrizDOFADetalle_Oportunidad'+j).style.borderColor = '#a94442');
                }
                  for(var j=0,i=descripcionDofaFortaleza.length; j<i;j++)
                {
                    (typeof respuesta['descripcionMatrizDOFADetalle_Fortaleza'+j] === "undefined" 
                        ? document.getElementById('descripcionMatrizDOFADetalle_Fortaleza'+j).style.borderColor = '' 
                        : document.getElementById('descripcionMatrizDOFADetalle_Fortaleza'+j).style.borderColor = '#a94442');
                }
                  for(var j=0,i=descripcionDofaAmenaza.length; j<i;j++)
                {
                    (typeof respuesta['descripcionMatrizDOFADetalle_Amenaza'+j] === "undefined" 
                        ? document.getElementById('descripcionMatrizDOFADetalle_Amenaza'+j).style.borderColor = '' 
                        : document.getElementById('descripcionMatrizDOFADetalle_Amenaza'+j).style.borderColor = '#a94442');
                }
                  for(var j=0,i=descripcionDofaDebilidad.length; j<i;j++)
                {
                    (typeof respuesta['descripcionMatrizDOFADetalle_Debilidad'+j] === "undefined" 
                        ? document.getElementById('descripcionMatrizDOFADetalle_Debilidad'+j).style.borderColor = '' 
                        : document.getElementById('descripcionMatrizDOFADetalle_Debilidad'+j).style.borderColor = '#a94442');
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

