

function consultarInformeEntrevista(fechaInicio, fechaFin, Cargo, Tercero, accion)
{

    if (fechaInicio == '' || fechaFin == '') 
        alert('Verifique que los campos de fecha esten llenos.');
    else
    {
        condicion = '';

        if (Cargo != '')
            condicion = condicion + 'e.Cargo_idCargo = "'+Cargo+'"';

        if (Tercero != '') 
            condicion = condicion + ((condicion !='' && Tercero != '') ? ' and ' : '') + 'Tercero_idEntrevistador = "'+Tercero+'"';
        if (fechaInicio != '' && fechaFin != '')
            condicion = condicion + ((condicion !='' && fechaInicio !='') ? ' and ' : '') + 'fechaEntrevista >= "'+fechaInicio+'" and fechaEntrevista <= "'+fechaFin+'"';
        
        imprimirInforme(condicion, accion);
    }
}


function imprimirInforme(condicion, accion)
{
    estados = $("#estadoEntrevistaResultado").val();
 
    var token = document.getElementById('token').value; 

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'condicion': condicion, 'estados': estados, 'accion': accion},
            url:   'http://'+location.host+'/consultarinformeEntrevista/',
            type:  'POST',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(respuesta){
                $("#informe").html(respuesta);
               
               
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}





function seleccionarEstado()
{
    // Se hace dentro de esta funcion un switch para cambiar el value numero por el nombre como tal de estado
            switch(('#Estado').val()) 
            {
                
                case 1 : estado += 'EnProceso,';
                    break;
                case 2 :estado += 'EnProceso,';
                    break;
                case 3():estado += 'EnProceso,';
                    break;
            }
        $("#estadoEntrevistaResultado").val('#Estado');
}
    



 
function imprimirEntrevistaResultado(id)
{
    window.open('entrevistaresultado/'+id+'?accion=imprimir','Formato','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}