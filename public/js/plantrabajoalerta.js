function imprimirPlanTrabajoAlerta(id)
{
    window.open('plantrabajoalerta/'+id+'?accion=imprimir','Formato','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}



function llenarplantrabajoalertaModelo(idPlanTrabajoAlertaModulo) //recibo el id del rol que voy a mandar desde el formulario
{
    // Ejecuto un ajax y por post envio el id del rol para la consulta
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idPlanTrabajoAlertaModulo': idPlanTrabajoAlertaModulo}, 
            url:   'http://'+location.host+'/llenarplantrabajoalertaModelo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){

                for (var i = 0; i < respuesta.length; i++) 
                {
                    $("#Modulo_idModulo"+i).val(respuesta[i]['Modulo_idModulo']);
                }
                
            },
            error: function(xhr,err){ 
                alert("Error");
            }
        });
}
