function  ValidarCapacidad(registro,tipo)
{
    // Se valida si el rango es inicial o final para saber que posicion tomar 
    if (tipo == 'Inicial')
        {   
            // Si es tipo frecuencia el va reemplzar el nombre por vacio para saber en que posicion va y del mismo modo si es rangoFinal
            reg = registro.replace('capacidadInicialCalibracionEquipoSeguimientoDetalle', '');
        }
    else if (tipo == 'Final') 
        {
            reg = registro.replace('capacidadFinalCalibracionEquipoSeguimientoDetalle', '')
        }

        // Se validan los campos para tener al final, facilidade manejo 
        Capainicial = ($("#capacidadInicialCalibracionEquipoSeguimientoDetalle"+reg).val() == '' ? '' : $("#capacidadInicialCalibracionEquipoSeguimientoDetalle"+reg).val());
        CapaFinal = ($("#capacidadFinalCalibracionEquipoSeguimientoDetalle"+reg).val() == '' ? '' : $("#capacidadFinalCalibracionEquipoSeguimientoDetalle"+reg).val());


    if (parseFloat(Capainicial) > parseFloat(CapaFinal) || parseFloat(Capainicial) == parseFloat(CapaFinal))

    {
         alert('La Capacidad inicial  '+Capainicial+'  Debe ser menor a la Capacidad final  '+CapaFinal);

    } 
}


function  ValidarRangos(registro,tipo)
{
    // Se valida si el rango es inicial o final para saber que posicion tomar 
    if (tipo == 'Inicial')
        {   
            // Si es tipo frecuencia el va reemplzar el nombre por vacio para saber en que posicion va y del mismo modo si es rangoFinal
            reg = registro.replace('rangoInicialCalibracionEquipoSeguimientoDetalle', '');
        }
    else if (tipo == 'Final') 
        {
            reg = registro.replace('rangoFinalCalibracionEquipoSeguimientoDetalle', '')
        }

        // Se validan los campos para tener al final, facilidade manejo 
        inicial = ($("#rangoInicialCalibracionEquipoSeguimientoDetalle"+reg).val() == '' ? '' : $("#rangoInicialCalibracionEquipoSeguimientoDetalle"+reg).val());
        Final = ($("#rangoFinalCalibracionEquipoSeguimientoDetalle"+reg).val() == '' ? '' : $("#rangoFinalCalibracionEquipoSeguimientoDetalle"+reg).val());


    if (parseFloat(inicial) > parseFloat(Final) || parseFloat(inicial) == parseFloat(Final))

    {
         alert('El rango inicial  '+inicial+'  Debe ser menor al rango final  '+Final);

    } 
}





function validarFormulario(event)
{
    var route = "http://"+location.host+"/equiposeguimiento";
    var token = $("#token").val();
    var dato0 = document.getElementById('idEquipoSeguimiento').value;
    var dato1 = document.getElementById('fechaEquipoSeguimiento').value;
    var dato2 = document.getElementById('nombreEquipoSeguimiento').value;
    var dato3 = document.getElementById('Tercero_idResponsable').value;
 
 
    var Identificacion = document.querySelectorAll("[name='identificacionEquipoSeguimientoDetalle[]']");
    var Tipo = document.querySelectorAll("[name='tipoEquipoSeguimientoDetalle[]']");
    var UnidadMedida = document.querySelectorAll("[name='unidadMedidaCalibracionEquipoSeguimientoDetalle[]']");
    
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    
    var valor = '';
    var sw = true;
    
    
    for(var j=0,i= Identificacion.length; j<i;j++)
    {
        dato4[j] = Identificacion[j].value;
    }
     for(var j=0,i= Tipo.length; j<i;j++)
    {
        dato5[j] = Tipo[j].value;
    }
     for(var j=0,i= UnidadMedida.length; j<i;j++)
    {
        dato6[j] = UnidadMedida[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEquipoSeguimiento: dato0,
                fechaEquipoSeguimiento: dato1,
                nombreEquipoSeguimiento: dato2,
                Tercero_idResponsable: dato3,
                identificacionEquipoSeguimientoDetalle: dato4,
                tipoEquipoSeguimientoDetalle: dato5,
                unidadMedidaCalibracionEquipoSeguimientoDetalle: dato6, 
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
               
                (typeof msj.responseJSON.fechaEquipoSeguimiento === "undefined" ? document.getElementById('fechaEquipoSeguimiento').style.borderColor = '' : document.getElementById('fechaEquipoSeguimiento').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreEquipoSeguimiento === "undefined" ? document.getElementById('nombreEquipoSeguimiento').style.borderColor = '' : document.getElementById('nombreEquipoSeguimiento').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idResponsable === "undefined" ? document.getElementById('Tercero_idResponsable').style.borderColor = '' : document.getElementById('Tercero_idResponsable').style.borderColor = '#a94442');
               

         
                for(var j=0,i= Identificacion.length; j<i;j++)
                {
                    (typeof respuesta['identificacionEquipoSeguimientoDetalle'+j] === "undefined" 
                        ? document.getElementById('identificacionEquipoSeguimientoDetalle'+j).style.borderColor = '' 
                        : document.getElementById('identificacionEquipoSeguimientoDetalle'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i= Tipo.length; j<i;j++)
                {
                    (typeof respuesta['tipoEquipoSeguimientoDetalle'+j] === "undefined" 
                        ? document.getElementById('tipoEquipoSeguimientoDetalle'+j).style.borderColor = '' 
                        : document.getElementById('tipoEquipoSeguimientoDetalle'+j).style.borderColor = '#a94442');
                }
                for(var j=0,i= UnidadMedida.length; j<i;j++)
                {
                    (typeof respuesta['unidadMedidaCalibracionEquipoSeguimientoDetalle'+j] === "undefined" 
                        ? document.getElementById('unidadMedidaCalibracionEquipoSeguimientoDetalle'+j).style.borderColor = '' 
                        : document.getElementById('unidadMedidaCalibracionEquipoSeguimientoDetalle'+j).style.borderColor = '#a94442');
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

// function CalcularNivelValor(registro, tipo)
// {
//     var Multiplicacion = 0;

//     if (tipo == 'frecuencia')
//     {   
//         // Si es tipo frecuencia el va reemplzar el nombre por vacio para saber en que posicion va y del mismo modo si es impacto
//         reg = registro.replace('frecuenciaMatrizRiesgoProcesoDetalle', '');
//     }
//     else if (tipo == 'impacto') 
//     {
//         reg = registro.replace('impactoMatrizRiesgoProcesoDetalle', '')
//     }

//     frecuencia = ($("#frecuenciaMatrizRiesgoProcesoDetalle"+reg).val() == '' ? 0 : $("#frecuenciaMatrizRiesgoProcesoDetalle"+reg).val());
//     impacto = ($("#impactoMatrizRiesgoProcesoDetalle"+reg).val() == '' ? 0 : $("#impactoMatrizRiesgoProcesoDetalle"+reg).val());

//     Multiplicacion = parseFloat(frecuencia) * parseFloat(impacto);

//     $("#nivelValorMatrizRiesgoProcesoDetalle"+reg).val(Multiplicacion);

//     // Variable que contiene el resultado de la condicion de la multiplicacion
//     interpretacion = '';

//     if (Multiplicacion ==  9)
//     {
//         interpretacion = "Alto";
//     }
//     else if (Multiplicacion == 1) 
//     {
//         interpretacion = 'Baja';
//     }
//     // Finalmene esta condicion  es diferente  se pregunt al mismo tiempo  >= 2 y <= 6 y adicional que sea diferente != 0 
//     // para que cuando estn eligiendo la opcion no muestre  la palabra Media
//     else if (Multiplicacion >= 2  || Multiplicacion <= 6 && Multiplicacion != 0) 
//     {
//         interpretacion = 'Media';
//     }

//     $("#interpretacionValorMatrizRiesgoProcesoDetalle"+reg).val(interpretacion);
// }



