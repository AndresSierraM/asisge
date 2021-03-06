
function validarFormulario(event)
{
    var route = "http://"+location.host+"/equiposeguimientoverificacion";
    var token = $("#token").val();
    var dato0 = document.getElementById('idEquipoSeguimientoVerificacion').value;
    var dato1 = document.getElementById('fechaEquipoSeguimientoVerificacion').value;
    var dato2 = document.getElementById('EquipoSeguimiento_idEquipoSeguimiento').value;
    var dato3 = document.getElementById('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle').value;
    var dato4 = document.getElementById('errorEncontradoEquipoSeguimientoVerificacion').value;

 

    var valor = '';
    var sw = true;
    
    


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEquipoSeguimientoVerificacion: dato0,
                fechaEquipoSeguimientoVerificacion: dato1,
                EquipoSeguimiento_idEquipoSeguimiento: dato2,
                EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle: dato3,
                errorEncontradoEquipoSeguimientoVerificacion: dato4,
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
               
                (typeof msj.responseJSON.fechaEquipoSeguimientoVerificacion === "undefined" ? document.getElementById('fechaEquipoSeguimientoVerificacion').style.borderColor = '' : document.getElementById('fechaEquipoSeguimientoVerificacion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.EquipoSeguimiento_idEquipoSeguimiento === "undefined" ? document.getElementById('EquipoSeguimiento_idEquipoSeguimiento').style.borderColor = '' : document.getElementById('EquipoSeguimiento_idEquipoSeguimiento').style.borderColor = '#a94442');

                (typeof msj.responseJSON.EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle === "undefined" ? document.getElementById('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle').style.borderColor = '' : document.getElementById('EquipoSeguimientoDetalle_idEquipoSeguimientoDetalle').style.borderColor = '#a94442');

                 (typeof msj.responseJSON.errorEncontradoEquipoSeguimientoVerificacion === "undefined" ? document.getElementById('errorEncontradoEquipoSeguimientoVerificacion').style.borderColor = '' : document.getElementById('errorEncontradoEquipoSeguimientoVerificacion').style.borderColor = '#a94442');

               

         

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
// Funcion para comrar el campo Errro Encontrado en Equipo Seguimiento verificacion con el campo ERROR permitido de la multiregistro de equipo seguimiento detalle
function CompararErrorEquipo(idEquipoSeguimientoDetalle)
{
      var token = document.getElementById('token').value;

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            dataType: "json",
            data: {'idEquipoSeguimientoDetalle': idEquipoSeguimientoDetalle},
            url:   'http://'+location.host+'/compararErrorEquipoVerificacion/',
            type:  'post',
            beforeSend: function(){
                //Lo que se hace antes de enviar el formulario
                },

            success: function(respuesta){ 

             Resultado = null;
                // Se valida si el campo consultado del ajax es Nulo si es asi mostrara el mensaje 
                if (respuesta[0]["errorPermitidoCalibracionEquipoSeguimientoDetalle"] ==  null) 
                {
                    Resultado = 'Debe ingresar el Error Máximo permitido en el Módulo Equipos de Seguimiento y Medición en el Detalle';
                }
                // Se compara los errores si mayor mostrara en el campo resultado . No apto de lo contrario apto 
                else if (parseFloat($("#errorEncontradoEquipoSeguimientoVerificacion").val()) > respuesta[0]["errorPermitidoCalibracionEquipoSeguimientoDetalle"])
                {
                    Resultado = 'No Apto';
                }
                else if((parseFloat($("#errorEncontradoEquipoSeguimientoVerificacion").val()) <= respuesta[0]["errorPermitidoCalibracionEquipoSeguimientoDetalle"]))
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