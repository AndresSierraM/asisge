function validarFormulario(event)
{
    var route = "http://"+location.host+"/evaluacionproveedor";
    var token = $("#token").val();
    var dato0 = document.getElementById('idEvaluacionProveedor').value;
    var dato1 = document.getElementById('Tercero_idProveedor').value;
    
    var valor = '';
    var sw = true;

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idEvaluacionProveedor: dato0,
                Tercero_idProveedor: dato1
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

                (typeof msj.responseJSON.Tercero_idProveedor === "undefined" ? document.getElementById('Tercero_idProveedor').style.borderColor = '' : document.getElementById('Tercero_idProveedor').style.borderColor = '#a94442');
                
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


function cargarResultadoProveedor(idProveedor)
{
    var token = document.getElementById('token').value;

    fechaInicial = $("#fechaInicialEvaluacionProveedor").val();
    fechaFinal = $("#fechaFinalEvaluacionProveedor").val();

    if(fechaInicial != '' && fechaFinal == '')
    {
        alert('Debe llenar la fecha final');
        return;
    }

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idProveedor': idProveedor, 'fechaInicial': fechaInicial, 'fechaFinal': fechaFinal},
        url:   'http://'+location.host+'/cargarResultadoProveedor/',
        type:  'post',
        beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
            },
        success: function(respuesta){

            ids = '';
            for (var i = 0; i < resultado.contador; i++) 
            {
                ids += $("#idEvaluacionProveedorResultado"+i).val()+',';
            }
            $("#eliminarEvaluacionProveedor").val(ids);

            $("#contenedor_resultado").html('');
            if(respuesta.length <= 0)
            {
                alert('No se encontraron registros.');
                $('#totalResultado').val(0);
            }
            else
            {
                for (var i = 0; i < respuesta.length; i++) 
                {
                    var valores = new Array(respuesta[i]['descripcionReciboCompraResultado'], respuesta[i]['porcentajeReciboCompraResultado'], respuesta[i]['pesoReciboCompraResultado'], respuesta[i]['resultadoReciboCompraResultado'], 0);
                    window.parent.resultado.agregarCampos(valores,'A');
                }
                calcularTotales();
            }
        },
        error:    function(xhr,err){ 
            alert("Error");
        }
    });
}

function calcularTotales()
{
    totalrecibo = 0;

    for(var i = 0; i < resultado.contador; i++)
    {
        if(typeof $("#resultadoEvaluacionProveedorResultado"+i, window.parent.document).val() != 'undefined')
        {
            totalrecibo += parseFloat($("#resultadoEvaluacionProveedorResultado"+i, window.parent.document).val());
        }
    }
            
    $('#totalResultado', window.parent.document).val(totalrecibo);
}


function imprimirFormato(idEvaluacionProveedor)
{
    window.open('evaluacionproveedor/'+idEvaluacionProveedor+'?idEvaluacionProveedor='+idEvaluacionProveedor+'&accion=imprimir','ordencompra','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}