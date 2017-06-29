
$(document).ready(function(){ 

    cargarDatosOrdenProduccion(idProceso);

    //**************************
    // 
    //   D E T A L L E
    //
    //**************************
    detalle = new Atributos('detalle','contenedor_detalle','detalle_');

    detalle.altura = '35px';
    detalle.campoid = 'idOrdenTrabajoDetalle';
    detalle.campoEliminacion = 'eliminarProceso';

    detalle.campos   = ['idOrdenTrabajoDetalle', 
                    'TipoCalidad_idTipoCalidad',
                    'cantidadOrdenTrabajoDetalle'];

    detalle.etiqueta = ['input', 'select','input'];
    detalle.tipo     = ['hidden', '','text'];
    detalle.estilo   = ['','width: 400px;height:35px;','width: 150px;height:35px;'];
    detalle.clase    = ['','',''];      
    detalle.sololectura = [false,false,false];
    detalle.opciones = ['',tipocalidad,''];
    console.log(detalles.length);
    for(var j=0, k = detalles.length; j < k; j++)
    {
        detalle.agregarCampos(JSON.stringify(detalles[j]),'L');
       
    }

    //**************************
    // 
    //   O P E R A C I O N E S
    //
    //**************************
    operacion = new Atributos('operacion','contenedor_operacion','operacion_');

    operacion.altura = '35px';
    operacion.campoid = 'idOrdenTrabajoOperacion';
    operacion.campoEliminacion = 'eliminarOperacion';
    operacion.botonEliminacion = false;

    operacion.campos   = ['idOrdenTrabajoOperacion',
                        'ordenOrdenTrabajoOperacion', 
                        'nombreOrdenTrabajoOperacion', 
                        'samOrdenTrabajoOperacion'];

    operacion.etiqueta = ['input','input','input'];
    operacion.tipo     = ['hidden','text','text'];
    operacion.estilo   = ['','width: 400px;height:35px;','width: 150px;height:35px;'];
    operacion.clase    = ['','',''];      
    operacion.sololectura = [true,true,true];
    
    for(var j=0, k = operaciones.length; j < k; j++)
    {
        operacion.agregarCampos(JSON.stringify(operaciones[j]),'L');
    }

});

function cargarOrdenTrabajoPendiente() 
{
    detalle.borrarTodosCampos();
    var idOP = document.getElementById('OrdenProduccion_idOrdenProduccion').value;
    var idPRO = document.getElementById('Proceso_idProceso').value;
    if(idOP == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarOrdenTrabajoPendiente',
        data:{idOrdenProduccion: idOP,
            idProceso: idPRO},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            $("#cantidadOrdenTrabajo").val(0);
            var TotUnidades = 0;
            // adicionamos los registros de Cantidades por tipo de calidad de la orden de producciom a la orden de trabajo
            for (var i = 0;  i < data.length; i++) 
            {
                valores = Array(0, data[i]["TipoCalidad_idTipoCalidad"], data[i]["cantidadPendiente"]);
                detalle.agregarCampos(valores,'A');

                TotUnidades = parseFloat(TotUnidades) + parseFloat(data[i]["cantidadPendiente"]);
            }
            $("#cantidadOrdenTrabajo").val(TotUnidades);
            $("#cantidadPendiente").val(TotUnidades);
        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};

function cargarDatosOrdenProduccion(valorProceso) 
{
    
    var id = document.getElementById('OrdenProduccion_idOrdenProduccion').value;
    
    if(id == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarOrdenProduccionProceso',
        data:{idOrdenProduccion: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            
            $("#referenciaFichaTecnica").val(data[0]["referenciaFichaTecnica"]);
            $("#nombreFichaTecnica").val(data[0]["nombreFichaTecnica"]);
            $("#especificacionOrdenTrabajo").val(data[0]["especificacionOrdenProduccion"]);
            $("#nombreCompletoTercero").val(data[0]["nombreCompletoTercero"]);
            $("#numeroPedidoOrdenTrabajo").val(data[0]["numeroPedidoOrdenProduccion"]);
            $("#estadoOrdenTrabajo").val('Activo');


            $('#Proceso_idProceso').html('');
            var select = document.getElementById('Proceso_idProceso');

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione el Proceso';
            select.appendChild(option);
            for (var i = 0;  i < data.length; i++) 
            {
                option = document.createElement('option');
                option.value = data[i]['Proceso_idProceso'];
                option.text = data[i]['nombreProceso'];

                option.selected = (valorProceso == data[i]['Proceso_idProceso'] ? true : false);

                select.appendChild(option);
            }

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};

function cargarOrdenTrabajoOperaciones() 
{
    operacion.borrarTodosCampos();
    var idOP = document.getElementById('OrdenProduccion_idOrdenProduccion').value;
    var idPRO = document.getElementById('Proceso_idProceso').value;
    if(idOP == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarOrdenTrabajoOperaciones',
        data:{idOrdenProduccion: idOP,
            idProceso: idPRO},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            
            // adicionamos los registros de Cantidades por tipo de calidad de la orden de producciom a la orden de trabajo
            for (var i = 0;  i < data.length; i++) 
            {
                valores = Array(0, data[i]["ordenFichaTecnicaOperacion"], 
                                    data[i]["nombreFichaTecnicaOperacion"], data[i]["samFichaTecnicaOperacion"]);
                operacion.agregarCampos(valores,'A');
            }
        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};

function validarFormulario(event)
{
    
    var route = "http://"+location.host+"/ordenproduccion";
    var token = $("#token").val();

    var dato = document.getElementById('idOrdenProduccion').value;
    var dato0 = document.getElementById('numeroOrdenProduccion').value;
    var dato1 = document.getElementById('fechaElaboracionOrdenProduccion').value;
    var dato2 = document.getElementById('Tercero_idCliente').value;
    var dato3 = document.getElementById('FichaTecnica_idFichaTecnica').value;
    var dato4 = document.getElementById('cantidadOrdenProduccion').value;

    var datoOrden = document.querySelectorAll("[name='ordenOrdenProduccionProceso[]']");
    var datoProc = document.querySelectorAll("[name='nombreProceso[]']");
   
    var dato5 = [];
    var dato6 = [];
  
   

    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoOrden.length; j<i;j++)
    {
        dato5[j] = datoOrden[j].value;
    }

    for(var j=0,i=datoProc.length; j<i;j++)
    {
        dato6[j] = datoProc[j].value;
    }

   
    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idOrdenProduccion: dato,
                numeroOrdenProduccion: dato0,
                fechaElaboracionOrdenProduccion: dato1,
                Tercero_idCliente: dato2,
                FichaTecnica_idFichaTecnica: dato3,
                cantidadOrdenProduccion: dato4,

                ordenOrdenProduccionProceso : dato5, 
                nombreProceso: dato6 
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
                
                (typeof msj.responseJSON.numeroOrdenProduccion === "undefined" ? document.getElementById('numeroOrdenProduccion').style.borderColor = '' : document.getElementById('numeroOrdenProduccion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionOrdenProduccion === "undefined" ? document.getElementById('fechaElaboracionOrdenProduccion').style.borderColor = '' : document.getElementById('fechaElaboracionOrdenProduccion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idCliente === "undefined" ? document.getElementById('Tercero_idCliente').style.borderColor = '' : document.getElementById('Tercero_idCliente').style.borderColor = '#a94442');

                (typeof msj.responseJSON.FichaTecnica_idFichaTecnica === "undefined" ? document.getElementById('FichaTecnica_idFichaTecnica').style.borderColor = '' : document.getElementById('FichaTecnica_idFichaTecnica').style.borderColor = '#a94442');

                (typeof msj.responseJSON.cantidadOrdenProduccion === "undefined" ? document.getElementById('cantidadOrdenProduccion').style.borderColor = '' : document.getElementById('cantidadOrdenProduccion').style.borderColor = '#a94442');
        
                for(var j=0,i=datoProc.length; j<i;j++)
                {
                    (typeof respuesta['ordenOrdenProduccionProceso'+j] === "undefined" 
                        ? document.getElementById('ordenOrdenProduccionProceso'+j).style.borderColor = '' 
                        : document.getElementById('ordenOrdenProduccionProceso'+j).style.borderColor = '#a94442');

                    (typeof respuesta['nombreProceso'+j] === "undefined" 
                        ? document.getElementById('nombreProceso'+j).style.borderColor = '' 
                        : document.getElementById('nombreProceso'+j).style.borderColor = '#a94442');
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
