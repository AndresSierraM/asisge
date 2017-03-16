function validarFormulario(event)
{
    var route = "http://"+location.host+"/competencia";
    var token = $("#token").val();
    var dato0 = document.getElementById('idCompetencia').value;
    var dato1 = document.getElementById('nombreCompetencia').value;
    var dato2 = document.getElementById('estadoCompetencia').value;
 
    var CompetenciaDetalle = document.querySelectorAll("[name='preguntaCompetenciaPregunta[]']");
    var CompetenciaTipo = document.querySelectorAll("[name='respuestaCompetenciaPregunta[]']");
    var CompetenciaTipoPregunta = document.querySelectorAll("[name='estadoCompetenciaPregunta[]']");
    var CompetenciaOrden = document.querySelectorAll("[name='ordenCompetenciaPregunta[]']");


    var dato3 = [];
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    
    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= CompetenciaDetalle.length; j<i;j++)
    {
        dato3[j] = CompetenciaDetalle[j].value;
    }

    for(var j=0,i= CompetenciaTipo.length; j<i;j++)
    {
        dato4[j] = CompetenciaTipo[j].value;
    }
       for(var j=0,i= CompetenciaTipoPregunta.length; j<i;j++)
    {
        dato5[j] = CompetenciaTipoPregunta[j].value;
    }

    for(var j=0,i= CompetenciaOrden.length; j<i;j++)
    {
        dato6[j] = CompetenciaOrden[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idCompetencia: dato0,
                nombreCompetencia: dato1,
                estadoCompetencia: dato2,
                preguntaCompetenciaPregunta: dato3,
                respuestaCompetenciaPregunta: dato4,
                estadoCompetenciaPregunta: dato5,
                ordenCompetenciaPregunta: dato6,
                // solo se modifica los campos del data
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
               
                (typeof msj.responseJSON.nombreCompetencia === "undefined" ? document.getElementById('nombreCompetencia').style.borderColor = '' : document.getElementById('nombreCompetencia').style.borderColor = '#a94442');

                (typeof msj.responseJSON.estadoCompetencia === "undefined" ? document.getElementById('estadoCompetencia').style.borderColor = '' : document.getElementById('estadoCompetencia').style.borderColor = '#a94442');

                
         
                for(var j=0,i=CompetenciaDetalle.length; j<i;j++)
                {
                    (typeof respuesta['preguntaCompetenciaPregunta'+j] === "undefined" 
                        ? document.getElementById('preguntaCompetenciaPregunta'+j).style.borderColor = '' 
                        : document.getElementById('preguntaCompetenciaPregunta'+j).style.borderColor = '#a94442');
                }

                  for(var j=0,i=CompetenciaTipo.length; j<i;j++)
                {
                    (typeof respuesta['respuestaCompetenciaPregunta'+j] === "undefined" 
                        ? document.getElementById('respuestaCompetenciaPregunta'+j).style.borderColor = '' 
                        : document.getElementById('respuestaCompetenciaPregunta'+j).style.borderColor = '#a94442');
                }

                  for(var j=0,i=CompetenciaTipoPregunta.length; j<i;j++)
                {
                    (typeof respuesta['estadoCompetenciaPregunta'+j] === "undefined" 
                        ? document.getElementById('estadoCompetenciaPregunta'+j).style.borderColor = '' 
                        : document.getElementById('estadoCompetenciaPregunta'+j).style.borderColor = '#a94442');
                }

                 for(var j=0,i=CompetenciaOrden.length; j<i;j++)
                {
                    (typeof respuesta['ordenCompetenciaPregunta'+j] === "undefined" 
                        ? document.getElementById('ordenCompetenciaPregunta'+j).style.borderColor = '' 
                        : document.getElementById('ordenCompetenciaPregunta'+j).style.borderColor = '#a94442');
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