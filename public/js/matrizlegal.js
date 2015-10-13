function validarFormulario(event)
{
    var route = "http://localhost:8000/matrizlegal";
    var token = $("#token").val();
    var dato1 = document.getElementById('nombreMatrizLegal').value;
    var dato2 = document.getElementById('fechaElaboracionMatrizLegal').value;
    var dato3 = document.getElementById('origenMatrizLegal').value;
    var datoProceso = document.querySelectorAll("[name='TipoNormaLegal_idTipoNormaLegal[]']");
    var datoClasificacion = document.querySelectorAll("[name='ExpideNormaLegal_idExpideNormaLegal[]']");
    var dato4 = [];
    var dato5 = [];
    
    
    var valor = '';
    var sw = true;
    for(var j=0,i=datoProceso.length; j<i;j++)
    {
        dato4[j] = datoProceso[j].value;
        dato5[j] = datoClasificacion[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                nombreMatrizLegal: dato1,
                fechaElaboracionMatrizLegal: dato2,
                origenMatrizLegal: dato3,
                TipoNormaLegal_idTipoNormaLegal: dato4,
                ExpideNormaLegal_idExpideNormaLegal: dato5
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

                for(var j=0,i=datoProceso.length; j<i;j++)
                {
                    mensaje += (typeof respuesta['TipoNormaLegal_idTipoNormaLegal'+j] === "undefined" ? '' : '<ul>'+respuesta['TipoNormaLegal_idTipoNormaLegal'+j]+'</ul>')+''+
                        (typeof respuesta['ExpideNormaLegal_idExpideNormaLegal'+j] === "undefined" ? '' : '<ul>'+respuesta['ExpideNormaLegal_idExpideNormaLegal'+j]+'</ul>');
                }
                $("#msj").html(
                    (typeof msj.responseJSON.nombreMatrizLegal === "undefined" ? '' : '<ul>'+msj.responseJSON.nombreMatrizLegal+'</ul>')+''+
                    (typeof msj.responseJSON.origenMatrizLegal === "undefined" ? '' : '<ul>'+msj.responseJSON.origenMatrizLegal+'</ul>')+''+
                    (typeof msj.responseJSON.fechaElaboracionMatrizLegal === "undefined" ? '' : '<ul>'+msj.responseJSON.fechaElaboracionMatrizLegal+'</ul>')+''+
                    mensaje
                    );
                $("#msj-error").fadeIn();
            }
                
        }        
    });
    
    if(sw === true)
        event.preventDefault();
}