
$(document).ready(function(){ 

    // carga los datos del encabezado 
    cargarDatosOrdenTrabajo(idOrdenTrabajo);

    //**************************
    // 
    //   D E T A L L E
    //
    //**************************
    detalle = new Atributos('detalle','contenedor_detalle','detalle_');

    detalle.altura = '35px';
    detalle.campoid = 'idEjecucionTrabajoDetalle';
    detalle.campoEliminacion = 'eliminarDetalle';

    detalle.campos   = ['idEjecucionTrabajoDetalle', 
                    'TipoCalidad_idTipoCalidad',
                    'cantidadEjecucionTrabajoDetalle'];

    detalle.etiqueta = ['input', 'select','input'];
    detalle.tipo     = ['hidden', '','text'];
    detalle.estilo   = ['','width: 400px;height:35px;','width: 150px;height:35px;'];
    detalle.clase    = ['','',''];      
    detalle.sololectura = [false,false,false];
    detalle.opciones = ['',tipocalidad,''];
    detalle.funciones = ['','',['onblur','calcularTotalUnidades();']];

    for(var j=0, k = detalles.length; j < k; j++)
    {
        detalle.agregarCampos(JSON.stringify(detalles[j]),'L');
       
    }

    
});


function cargarDatosOrdenTrabajo(idOrdenTrabajo) 
{
    
    var id = document.getElementById('OrdenTrabajo_idOrdenTrabajo').value;
    
    if(id == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarOrdenTrabajo',
        data:{idOrdenTrabajo: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            
            $("#referenciaFichaTecnica").val(data[0]["referenciaFichaTecnica"]);
            $("#nombreFichaTecnica").val(data[0]["nombreFichaTecnica"]);
            $("#especificacionOrdenTrabajo").val(data[0]["especificacionOrdenProduccion"]);
            $("#nombreProceso").val(data[0]["nombreProceso"]);
            $("#nombreCompletoTercero").val(data[0]["nombreCompletoTercero"]);
            $("#numeroOrdenProduccion").val(data[0]["numeroOrdenProduccion"]);
            $("#numeroPedidoEjecucionTrabajo").val(data[0]["numeroPedidoOrdenProduccion"]);
            $("#estadoEjecucionTrabajo").val('Activo');

            
        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};


function cargarDatosEjecucionTrabajoPendiente(idOrdenTrabajo) 
{
    detalle.borrarTodosCampos();
    var id = document.getElementById('OrdenTrabajo_idOrdenTrabajo').value;
    
    if(id == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarEjecucionTrabajoPendiente',
        data:{idOrdenTrabajo: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {

            $("#cantidadEjecucionTrabajo").val(0);
            var TotUnidades = 0;
            // adicionamos los registros de Cantidades por tipo de calidad de la orden de producciom a la orden de trabajo
            for (var i = 0;  i < data.length; i++) 
            {
                valores = Array(0, data[i]["TipoCalidad_idTipoCalidad"], data[i]["cantidadPendiente"]);
                detalle.agregarCampos(valores,'A');

                TotUnidades = parseFloat(TotUnidades) + parseFloat(data[i]["cantidadPendiente"]);
            }
            $("#cantidadEjecucionTrabajo").val(TotUnidades);
            $("#cantidadPendiente").val(TotUnidades);
            
        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};


function calcularTotalUnidades()
{
    $("#cantidadEjecucionTrabajo").val(0);
    for (var i = 0;  i < detalle.contador; i++) 
    {
        $("#cantidadEjecucionTrabajo").val(parseFloat($("#cantidadEjecucionTrabajo").val()) + parseFloat($("#cantidadEjecucionTrabajoDetalle"+i).val()));
    }
}

function validarFormulario(event)
{
    
    var route = "http://"+location.host+"/ordentrabajo";
    var token = $("#token").val();

    var dato = document.getElementById('idOrdenTrabajo').value;
    var dato0 = document.getElementById('numeroOrdenTrabajo').value;
    var dato1 = document.getElementById('fechaElaboracionOrdenTrabajo').value;
    var dato2 = document.getElementById('OrdenProduccion_idOrdenProduccion').value;
    var dato3 = document.getElementById('Proceso_idProceso').value;
    var dato4 = document.getElementById('cantidadOrdenTrabajo').value;

    var datoOrden = document.querySelectorAll("[name='TipoCalidad_idTipoCalidad[]']");
    var datoCant = document.querySelectorAll("[name='cantidadOrdenTrabajoDetalle[]']");
   
    var dato5 = [];
    var dato6 = [];

    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoOrden.length; j<i;j++)
    {
        dato5[j] = datoOrden[j].value;
    }

    for(var j=0,i=datoCant.length; j<i;j++)
    {
        dato6[j] = datoCant[j].value;
    }

   
    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idOrdenTrabajo: dato,
                numeroOrdenTrabajo: dato0,
                fechaElaboracionOrdenTrabajo: dato1,
                OrdenProduccion_idOrdenProduccion: dato2,
                Proceso_idProceso: dato3,
                cantidadOrdenTrabajo: dato4,

                TipoCalidad_idTipoCalidad : dato5, 
                cantidadOrdenTrabajoDetalle: dato6 
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
                
                (typeof msj.responseJSON.numeroOrdenTrabajo === "undefined" ? document.getElementById('numeroOrdenTrabajo').style.borderColor = '' : document.getElementById('numeroOrdenTrabajo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionOrdenTrabajo === "undefined" ? document.getElementById('fechaElaboracionOrdenTrabajo').style.borderColor = '' : document.getElementById('fechaElaboracionOrdenTrabajo').style.borderColor = '#a94442');

                (typeof msj.responseJSON.OrdenProduccion_idOrdenProduccion === "undefined" ? document.getElementById('OrdenProduccion_idOrdenProduccion').style.borderColor = '' : document.getElementById('OrdenProduccion_idOrdenProduccion').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Proceso_idProceso === "undefined" ? document.getElementById('Proceso_idProceso').style.borderColor = '' : document.getElementById('Proceso_idProceso').style.borderColor = '#a94442');

                (typeof msj.responseJSON.cantidadOrdenTrabajo === "undefined" ? document.getElementById('cantidadOrdenTrabajo').style.borderColor = '' : document.getElementById('cantidadOrdenTrabajo').style.borderColor = '#a94442');
        
                for(var j=0,i=datoCant.length; j<i;j++)
                {
                    (typeof respuesta['TipoCalidad_idTipoCalidad'+j] === "undefined" 
                        ? document.getElementById('TipoCalidad_idTipoCalidad'+j).style.borderColor = '' 
                        : document.getElementById('TipoCalidad_idTipoCalidad'+j).style.borderColor = '#a94442');

                    (typeof respuesta['cantidadOrdenTrabajoDetalle'+j] === "undefined" 
                        ? document.getElementById('cantidadOrdenTrabajoDetalle'+j).style.borderColor = '' 
                        : document.getElementById('cantidadOrdenTrabajoDetalle'+j).style.borderColor = '#a94442');
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
