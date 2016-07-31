function validarFormulario(event)
{
    var route = "http://"+location.host+"/entregaelementoproteccion";
    var token = $("#token").val();
    var dato0 = document.getElementById('idEntregaElementoProteccion').value;
    var dato1 = document.getElementById('Tercero_idTercero').value;
    var dato2 = document.getElementById('fechaEntregaElementoProteccion').value;
    var datoElemento = document.querySelectorAll("[name='ElementoProteccion_idElementoProteccion[]']");
    var datoCantidad = document.querySelectorAll("[name='cantidadEntregaElementoProteccionDetalle[]']");
    var dato3 = [];
    var dato4 = [];

    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoElemento.length; j<i;j++)
    {
        dato3[j] = datoElemento[j].value;
    }

    for(var j=0,i=datoCantidad.length; j<i;j++)
    {
        dato4[j] = datoCantidad[j].value;
    }


    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEntregaElementoProteccion: dato0,
                Tercero_idTercero: dato1,
                fechaEntregaElementoProteccion: dato2,
                ElementoProteccion_idElementoProteccion: dato3,
                cantidadEntregaElementoProteccionDetalle: dato4, 
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

                (typeof msj.responseJSON.Tercero_idTercero === "undefined" ? document.getElementById('Tercero_idTercero').style.borderColor = '' : document.getElementById('Tercero_idTercero').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaEntregaElementoProteccion === "undefined" ? document.getElementById('fechaEntregaElementoProteccion').style.borderColor = '' : document.getElementById('fechaEntregaElementoProteccion').style.borderColor = '#a94442');


                for(var j=0,i=datoElemento.length; j<i;j++)
                {
                    (typeof respuesta['ElementoProteccion_idElementoProteccion'+j] === "undefined" 
                        ? document.getElementById('ElementoProteccion_idElementoProteccion'+j).style.borderColor = '' 
                        : document.getElementById('ElementoProteccion_idElementoProteccion'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoCantidad.length; j<i;j++)
                {
                    (typeof respuesta['cantidadEntregaElementoProteccionDetalle'+j] === "undefined" ? document.getElementById('cantidadEntregaElementoProteccionDetalle'+j).style.borderColor = '' : document.getElementById('cantidadEntregaElementoProteccionDetalle'+j).style.borderColor = '#a94442');
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



function llenarCargo(idTercero)
{
         var token = document.getElementById('token').value;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'idTercero': idTercero},
                url:   'http://'+location.host+'/llenarCargo/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    //lo que se si el destino devuelve algo
                    $("#nombreCargo").val(respuesta); //Al input nombreCargo le envío la respuesta de la consulta
                                                      //realizada en llenarCargo
                },
                error:    function(xhr,err){ 
                    alert("Error");
                }
            });
}

function llenarDescripcion(idElementoProteccion,nombreCampo)
{
    var registro = nombreCampo.substring(39); //Le quito la palabra 'ElementoProteccion_idElementoProteccion'y solo envío el número del registro
    var token = document.getElementById('token').value; 

    //Pregunto si el idElemento es diferente a vacío y de ser así lleno el campo descripcion y si no lo es
    //este quedará vacío
    if(idElementoProteccion > 0 && idElementoProteccion != '')
    {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'ElementoProteccion_idElementoProteccion': idElementoProteccion},
                url:   'http://'+location.host+'/llenarDescripcion/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    //lo que se si el destino devuelve algo
                    $("#descripcionElementoProteccion"+registro).val(respuesta);
                },
                error:    function(xhr,err){ 
                    alert("Error");
                }
            });
    }
    else
    {
        $("#descripcionElementoProteccion"+registro).val('');
    }
}