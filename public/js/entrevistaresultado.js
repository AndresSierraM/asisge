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
    
    var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'condicion': condicion},
            url:   'http://'+location.host+'/consultarinformeEntrevista/',
            type:  'POST',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },
            success: function(informehtml){
                $("#informe").html(informehtml);
               
               
            },
            error:    function(xhr,err){ 
                alert("Error");
            }
        });

}



$(document).ready( function () {

  $("#fechaInicialEntrevistaResultado").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );

 $("#fechaFinalEntrevistaResultado").datetimepicker
  (
    ({
       format: "YYYY-MM-DD"
     })
  );
});

function seleccionarEstado()
{
  var Estados = '';

  for(var t = 1; t <= 3; t++)
  {
    if($("#Estado"+t).prop('checked')==true);
      Estados += t+',';

  }

  $("#estadoEntrevista").val(Estados);

}




