

function consultarInformeEntrevista(fechaInicio, fechaFin, Cargo, Tercero)
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
        
        imprimirInforme(condicion);
    }
}


function imprimirInforme(condicion)
{
    estados = $("#estadoEntrevistaResultado").val();
    accion = $("#accionFormulario").val();
 
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
    estado = '';

    for (var i = 1; i <= 3; i++) 
    {
        if($('#Estado'+i).is(':checked')) 
        estado += i+',';
    }

    $("#estadoEntrevistaResultado").val(estado);
}
    



 
function imprimirEntrevistaResultado(id)
{
    window.open('entrevistaresultado/'+id+'?accion=imprimir','Formato','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}