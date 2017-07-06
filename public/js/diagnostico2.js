function validarFormularioREQUEST(event)
{
    var route = "http://"+location.host+"/diagnostico2";
    var token = $("#token").val();
    var dato0 = document.getElementById('idDiagnostico2').value;
    var dato1 = document.getElementById('codigoDiagnostico2').value;
    var dato2 = document.getElementById('nombreDiagnostico2').value;
    var dato3 = document.getElementById('fechaElaboracionDiagnostico2').value;
    var datoDetalle = document.querySelectorAll("[name='respuestaDiagnostico2Detalle[]']");
    var dato4 = [];
    var valor = '';
    var sw = true;

    for(var j=0,i=datoDetalle.length; j<i;j++)
    {
        dato4[j] = datoDetalle[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idDiagnostico2: dato0,
                codigoDiagnostico2: dato1,
                nombreDiagnostico2: dato2,
                fechaElaboracionDiagnostico2: dato3,
                respuestaDiagnostico2Detalle: dato4
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            //console.log(msj.responseJSON);
            var respuesta = JSON.stringify(msj.responseJSON); 
            //console.log(respuesta);
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

                (typeof msj.responseJSON.codigoDiagnostico2 === "undefined" ? document.getElementById('codigoDiagnostico2').style.borderColor = '' : document.getElementById('codigoDiagnostico2').style.borderColor = '#a94442');
                (typeof msj.responseJSON.nombreDiagnostico2 === "undefined" ? document.getElementById('nombreDiagnostico2').style.borderColor = '' : document.getElementById('nombreDiagnostico2').style.borderColor = '#a94442');
                (typeof msj.responseJSON.fechaElaboracionDiagnostico2 === "undefined" ? document.getElementById('fechaElaboracionDiagnostico2').style.borderColor = '' : document.getElementById('fechaElaboracionDiagnostico2').style.borderColor = '#a94442');

                for(var j=0,i=datoDetalle.length; j<i;j++)
                {

                    (typeof respuesta['respuestaDiagnostico2Detalle'+j] === "undefined" ? document.getElementById('respuestaDiagnostico2Detalle'+j).style.borderColor = '' : document.getElementById('respuestaDiagnostico2Detalle'+j).style.borderColor = '#a94442');
                }
                

                var mensaje = 'Por favor verifique los siguientes valores <br><ul>';
                $.each(respuesta,function(index, value){
                    mensaje +='<li>' +value+'</li>';
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





// function validarformulario()
// {
//     var resp = true;
//     // Validamos los datos de detalle
//     for(actual = 0; actual < document.getElementById('respuestaDiagnostico2Detalle').value ; actual++)
//     {
//         if(document.getElementById("respuestaDiagnostico2Detalle"+(actual)) && 
//             (document.getElementById("respuestaDiagnostico2Detalle"+(actual)).value == '' ||  
//             document.getElementById("respuestaDiagnostico2Detalle"+(actual)).value == 0))
//         {
//             document.getElementById("respuestaDiagnostico2Detalle"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:#F5A9A9;";
//             resp = false;
            
//         } 
//         else
//         {
//             document.getElementById("respuestaDiagnostico2Detalle"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:white;";
//         } 
//     }

//     if(resp === true)
//     {
//         $("form").submit();
//     }
//     else
//     {
//         alert('Por favor verifique los campos bordeados en rojo)');
//     }

//     return true;
// }