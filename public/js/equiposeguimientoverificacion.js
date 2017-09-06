// Funcion para comrar el campo Errro Encontrado en Equipo Seguimiento verificacion con el campo ERROR permitido de la multiregistro de equipo seguimiento detalle
function CompararErrorEquipo(idEquipoSeguimientoDetalle,ErrorEncontrado)
{
      var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idEquipoSeguimientoDetalle': idEquipoSeguimientoDetalle},
            url:   'http://'+location.host+'/compararErrorEquipo/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){ 

             Resultado = null;
                
                if (respuesta[0]["errorPermitidoCalibracionEquipoSeguimientoDetalle"] ==  null) 
                {
                    Resultado = 'Debe ingresar el Error Máximo permitido en el Módulo Equipos de Seguimiento y Medición en el Detalle';
                }
                else if (parseFloat($("#errorEncontradoEquipoSeguimientoVerificacion").val()) > respuesta[0]["errorPermitidoCalibracionEquipoSeguimientoDetalle"])
                {
                    Resultado = 'No Apto';
                }
                else if((parseFloat($("#errorEncontradoEquipoSeguimientoVerificacion").val()) < respuesta[0]["errorPermitidoCalibracionEquipoSeguimientoDetalle"]))
                {
                    Resultado = 'Apto';
                }

            $("#resultadoEquipoSeguimientoVerificacion").val(Resultado);
            },
            error:    function(xhr,err){ 
                alert("Error");
            }


        });
}

// Funcion para llenar el Codigo y el responsable del Equipo
function llenarCodigoResponsable(id , valor)
{
    //Se toma por medio de Id el del Equipo Seleccionado
    var select = document.getElementById('EquipoSeguimiento_idEquipoSeguimiento').value;
    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'http://'+location.host+'/llenarCodigoVerificacionEquipoSeguimiento', /*Funcion para ejecutar  el Ajax para que consulte en la BD la tabla de equipo seguimiento , detalle y tercero */
        data:{idequipseguimiento: id}, // Este id lo envia por get para el ajax
        type:  'get',   
        beforeSend: function(){},
        success: function(data)
        {
            // Se envia el nombre de usuarioque aparece en ese EQuipo
            $("#Tercero_idResponsable").val(data[0]["nombreCompletoTercero"]);
            /* cuando reciba la consulta, va a tomar el nombre de la lista de Codigo*/
            $('#EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle').html('');
            var select = document.getElementById('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle');
            /*Recibe el nombre hasta aca*/
            // Estas Option se utilizan para que agregue una primera opcion que diga seleccione 
            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione el Código';
            select.appendChild(option);
            //Recorre los registros de sublineas para irlos  creando como opciones en esa lista
            for (var i = 0;  i < data.length; i++) 
            {

                option = document.createElement('option');
                option.value = data[i]['idEquipoSeguimientoDetalle'];
                option.text = data[i]['identificacionEquipoSeguimientoDetalle'];
                option.selected = (valor == data[i]['idEquipoSeguimientoDetalle'] ? true : false);
                select.appendChild(option);
            }



        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: ' +err);
        }
    });

}