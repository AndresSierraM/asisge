function validarFormulario(event)
{
    var route = "http://"+location.host+"/recibocompra";
    var token = $("#token").val();
    var dato0 = document.getElementById('idReciboCompra').value;
    var dato1 = document.getElementById('fechaRealReciboCompra').value;
    var tipocalidad = document.querySelectorAll("[name='TipoCalidad_idTipoCalidad[]']");
    var dato2 = [];
    
    var valor = '';
    var sw = true;
    
    for(var j=0,i=tipocalidad.length; j<i;j++)
    {
        dato2[j] = tipocalidad[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idReciboCompra: dato0,
                fechaRealReciboCompra: dato1,
                TipoCalidad_idTipoCalidad: dato2
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

                (typeof msj.responseJSON.fechaRealReciboCompra === "undefined" ? document.getElementById('fechaRealReciboCompra').style.borderColor = '' : document.getElementById('fechaRealReciboCompra').style.borderColor = '#a94442');

                for(var j=0,i=tipocalidad.length; j<i;j++)
                {
                    (typeof respuesta['TipoCalidad_idTipoCalidad'+j] === "undefined" ? document.getElementById('TipoCalidad_idTipoCalidad'+j).style.borderColor = '' : document.getElementById('TipoCalidad_idTipoCalidad'+j).style.borderColor = '#a94442');
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

function abrirModalOrdenCompra()
{
    window.parent.$("#tordencompra tbody tr").each( function () 
    {
        $(this).removeClass('selected');
    });

    $("#divTabla").html('');

    estructuraTabla = '<div class="row" style="width:80%;">'+
                        '<div class="container" style="width:130%;">'+
                            '<table id="tordencompra" name="tordencompra" class="display table-bordered" width="60%">'+
                              '<thead>'+
                                  '<tr class="btn-default active">'+
                                      '<th><b>ID</b></th>'+
                                      '<th><b>Número de Orden</b></th> '+  
                                      '<th><b>Estimado de entrega</b></th> '+  
                                      '<th><b>ID Proveedor</b></th> '+ 
                                      '<th><b>Proveedor</b></th> '+       
                                  '</tr>'+
                              '</thead>'+
                              '<tfoot>'+
                                  '<tr class="btn-default active">'+

                                      '<th>ID</th>'+
                                      '<th>Número de Orden</th> '+  
                                      '<th>Estimado de entrega</th> '+  
                                      '<th>Proveedor</th> '+  
                                      '<th>ID Proveedor</th> '+                            
                                  '</tr>'+
                              '</tfoot>'+
                          '</table>'+
                          '<div class="modal-footer">'+
                        '<button id="botonFichaTecnica" name="botonFichaTecnica" type="button" class="btn btn-primary" >Seleccionar</button>'+
                        '</div>'+
                     '</div>';

    $("#divTabla").html(estructuraTabla);

    var lastIdx = null;
    window.parent.$("#tordencompra").DataTable().ajax.url('http://'+location.host+"/datosOrdenCompraModal").load();
     // Abrir modal
    window.parent.$("#modalOrdenCompra").modal();

    $("a.toggle-vis").on( "click", function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr("data-column") );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    window.parent.$("#tordencompra tbody").on( "mouseover", "td", function () 
    {
        var colIdx = table.cell(this).index().column;

        if ( colIdx !== lastIdx ) {
            $( table.cells().nodes() ).removeClass( "highlight" );
            $( table.column( colIdx ).nodes() ).addClass( "highlight" );
        }
    }).on( "mouseleave", function () 
    {
        $( table.cells().nodes() ).removeClass( "highlight" );
    } );


    // Setup - add a text input to each footer cell
    window.parent.$("#tordencompra tfoot th").each( function () 
    {
        var title = window.parent.$("#tordencompra thead th").eq( $(this).index() ).text();
        $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
    });
 
    // DataTable
    var table = window.parent.$("#tordencompra").DataTable();
 
    // Apply the search
    table.columns().every( function () 
    {
        var that = this;
 
        $( "input", this.footer() ).on( "blur change", function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    })

    $('#tordencompra tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );

    // window.parent.$("#tordencompra tbody").on( "dblclick", "tr", function () 
    // {
    //     if ( $(this).hasClass("selected") ) {
    //         $(this).removeClass("selected");
    //     }
    //     else {
    //         table.$("tr.selected").removeClass("selected");
    //         $(this).addClass("selected");
    //     }
    $('#botonFichaTecnica').click(function() {
        var datos = table.rows('.selected').data();

        if (datos.length > 0) 
        {
            $("#numeroOrdenCompra").val(datos[0][1]);
            $("#OrdenCompra_idOrdenCompra").val(datos[0][0]);
            $("#fechaEstimadaReciboCompra").val(datos[0][2]);
            $("#nombreProveedor").val(datos[0][4]);
            $("#Tercero_idProveedor").val(datos[0][3]);

            cargarProductos(datos[0][0]);
            cargarRecibos(datos[0][3], datos[0][2]);
        }

        window.parent.$("#modalOrdenCompra").modal("hide");

    } );
}

function cargarProductos(idOrdenCompra)
{
    var token = document.getElementById('token').value;

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idOrdenCompra': idOrdenCompra},
        url:   'http://'+location.host+'/cargarProductosOrdenCompra/',
        type:  'post',
        beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
            },
        success: function(respuesta){

            $("#contenedor_recibo").html('');
            for (var i = 0; i < respuesta.length; i++) 
            {
                var valores = new Array(respuesta[i]['idFichaTecnica'], respuesta[i]['referenciaFichaTecnica'], respuesta[i]['nombreFichaTecnica'], respuesta[i]['cantidadOrdenCompraProducto'], 0, '', '', respuesta[i]['valorUnitarioOrdenCompraProducto'], 0, 0, 0);
                window.parent.producto.agregarCampos(valores,'A');
            }
            calcularTotales();
        },
        error:    function(xhr,err){ 
            alert("Error");
        }
    });
}

function cargarRecibos(idProveedor, fechaEstimada)
{
    var token = document.getElementById('token').value;

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idProveedor': idProveedor},
        url:   'http://'+location.host+'/cargarResultadoReciboOrdenCompra/',
        type:  'post',
        beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
            },
        success: function(respuesta){

            ids = '';
            for (var i = 0; i < resultado.contador; i++) 
            {
                ids += $("#idReciboCompraResultado"+i).val()+',';
            }
            $("#eliminarReciboCompraResultado").val(ids);

            $("#contenedor_resultado").html('');
            for (var i = 0; i < respuesta.length; i++) 
            {   
                if(respuesta[i]['descripcionTipoProveedorEvaluacion'] == 'Fecha de Entrega')
                {
                    var fechaIni = fechaEstimada;
                    var fechaFin = $("#fechaElaboracionReciboCompra").val();

                    var fecha1 = new Date(fechaIni.substring(0,4),fechaIni.substring(5,7)-1);
	                var fecha2 = new Date(fechaFin.substring(0,4),fechaFin.substring(5,7)-1);
	                var diasDif = fecha2.getTime() - fecha1.getTime();
	                var dias = Math.floor(diasDif/(1000 * 60 * 60 * 24));
                    
                    var valores = new Array(respuesta[i]['descripcionTipoProveedorEvaluacion'], fechaEstimada, $("#fechaElaboracionReciboCompra").val(), dias, 0, respuesta[i]['pesoTipoProveedorEvaluacion'], 0, '', '');
                    window.parent.resultado.agregarCampos(valores,'A');
                }
                else if(respuesta[i]['descripcionTipoProveedorEvaluacion'] == 'Calidad')
                {
                    var valores = new Array(respuesta[i]['descripcionTipoProveedorEvaluacion'], 0, 0, 0, 0, respuesta[i]['pesoTipoProveedorEvaluacion'], 0, '', '');
                    window.parent.resultado.agregarCampos(valores,'A');
                }
                else if(respuesta[i]['descripcionTipoProveedorEvaluacion'] == 'Cantidad')
                {
                    total = 0;
                    for(var j = 0; j < producto.contador; j++)
                    {
                        total += parseFloat($("#cantidadOrdenCompraProducto"+j).val());
                    }
                    var valores = new Array(respuesta[i]['descripcionTipoProveedorEvaluacion'], total, 0, 0, 0, respuesta[i]['pesoTipoProveedorEvaluacion'], 0, '', '');
                    window.parent.resultado.agregarCampos(valores,'A');
                }
                else if(respuesta[i]['descripcionTipoProveedorEvaluacion'] == 'Precio')
                {
                    var valores = new Array(respuesta[i]['descripcionTipoProveedorEvaluacion'], 0, 0, 0, 0, respuesta[i]['pesoTipoProveedorEvaluacion'], 0, '', '');
                    window.parent.resultado.agregarCampos(valores,'A');
                }
            }
        },
        error:    function(xhr,err){ 
            alert("Error");
        }
    });
}

function calcularValorTotal(registro, tipo)
{
    reg = registro;
    if (tipo == 'cantidad') 
    {
        reg = registro.replace('cantidadReciboCompraProducto','');
    }
    else if(tipo == 'unitario')
    {
        reg = registro.replace('valorUnitarioReciboCompraProducto','');   
    }

    valor = parseFloat($("#cantidadReciboCompraProducto"+reg).val()) * parseFloat($("#valorUnitarioReciboCompraProducto"+reg).val());

    $("#valorTotalReciboCompraProducto"+reg).val(valor)    
}

function calcularTotales()
{
    totalrecibo = 0;
    totalproducto = 0;

    for (var i = 0; i < window.parent.producto.contador; i++) 
    {
        if(typeof $("#valorTotalReciboCompraProducto"+i, window.parent.document).val() != 'undefined' &&
            $("#valorTotalReciboCompraProducto"+i, window.parent.document).val() > 0)
        {
            totalrecibo += parseFloat($("#valorTotalReciboCompraProducto"+i, window.parent.document).val());
        }
    }

    for(var i = 0; i < resultado.contador; i++)
    {
        if(typeof $("#resultadoReciboCompraResultado"+i, window.parent.document).val() != 'undefined')
        {
            totalproducto += parseFloat($("#resultadoReciboCompraResultado"+i, window.parent.document).val());
        }
    }
            
    $('#totalProducto', window.parent.document).val(totalrecibo);
    $('#totalResultado', window.parent.document).val(totalproducto);
}

function calcularTotalRecibo()
{
    for(var i = 0; i < resultado.contador; i++)
    {
        if($("#descripcionReciboCompraResultado"+i).val() == 'Cantidad')
        {
            total = 0;
            for(var j = 0; j < producto.contador; j++)
            {
                total += parseFloat($("#cantidadReciboCompraProducto"+j).val());
            }

            $("#valorReciboReciboCompraResultado"+i).val(total);
            dif = parseFloat($("#valorCompraReciboCompraResultado"+i).val()) - parseFloat($("#valorReciboReciboCompraResultado"+i).val());
            $("#diferenciaReciboCompraResultado"+i).val(dif);

            porc = (parseFloat($("#diferenciaReciboCompraResultado"+i).val()) / parseFloat($("#valorCompraReciboCompraResultado"+i).val()))*100;
            $("#porcentajeReciboCompraResultado"+i).val(porc);

            result = parseFloat($("#porcentajeReciboCompraResultado"+i).val()) - parseFloat($("#pesoReciboCompraResultado"+i).val());
            $("#resultadoReciboCompraResultado"+i).val(result);
        }
        else if($("#descripcionReciboCompraResultado"+i).val() == 'Calidad')
        {
            totalcalidadoc = 0;
            totalcalidadrecibo = 0
            
            for(var j = 0; j < producto.contador; j++)
            {
                totalcalidadoc += parseFloat($("#cantidadReciboCompraProducto"+j).val());
            }

            for(var j = 0; j < producto.contador; j++)
            {
                if($("#productoConformeTipoCalidad"+j).val() == 0 && $("#productoConformeTipoCalidad"+j).val() != '' && $("#productoConformeTipoCalidad"+j).val() != 1)
                {   
                    totalcalidadrecibo += parseFloat($("#cantidadReciboCompraProducto"+j).val());
                }
            }
            
            $("#valorCompraReciboCompraResultado"+i).val(totalcalidadoc);
            $("#valorReciboReciboCompraResultado"+i).val(totalcalidadrecibo);

            dif = parseFloat($("#valorCompraReciboCompraResultado"+i).val()) - parseFloat($("#valorReciboReciboCompraResultado"+i).val());
            $("#diferenciaReciboCompraResultado"+i).val(dif);

            porc = (parseFloat($("#diferenciaReciboCompraResultado"+i).val()) / parseFloat($("#valorCompraReciboCompraResultado"+i).val()))*100;
            $("#porcentajeReciboCompraResultado"+i).val(porc);

            result = parseFloat($("#porcentajeReciboCompraResultado"+i).val()) * parseFloat($("#pesoReciboCompraResultado"+i).val())/100;
            $("#resultadoReciboCompraResultado"+i).val(result);
        }
        else if($("#descripcionReciboCompraResultado"+i).val() == 'Precio')
        {
            totaloc = 0;
            totalrecibo = 0;
            for(var j = 0; j < producto.contador; j++)
            {
                totaloc += parseFloat($("#cantidadReciboCompraProducto"+j).val()) * parseFloat($("#valorUnitarioOrdenCompraProducto"+j).val());
                totalrecibo += parseFloat($("#cantidadReciboCompraProducto"+j).val()) * parseFloat($("#valorUnitarioReciboCompraProducto"+j).val());
            }
            $("#valorCompraReciboCompraResultado"+i).val(totaloc);
            $("#valorReciboReciboCompraResultado"+i).val(totalrecibo);

            dif = parseFloat($("#valorCompraReciboCompraResultado"+i).val()) - parseFloat($("#valorReciboReciboCompraResultado"+i).val());
            $("#diferenciaReciboCompraResultado"+i).val(dif);

            porc = (parseFloat($("#diferenciaReciboCompraResultado"+i).val()) / parseFloat($("#valorCompraReciboCompraResultado"+i).val()))*100;
            $("#porcentajeReciboCompraResultado"+i).val(porc);

            result = parseFloat($("#porcentajeReciboCompraResultado"+i).val()) * parseFloat($("#pesoReciboCompraResultado"+i).val())/100;
            $("#resultadoReciboCompraResultado"+i).val(result);
        }
    }

    calcularTotales();
}

function consultarNoConformeTipoCalidad(registro, idTipoCalidad)
{
    var token = document.getElementById('token').value;

    $.ajax({
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idTipoCalidad': idTipoCalidad},
        url:   'http://'+location.host+'/consultarNoConformeTipoCalidad/',
        type:  'post',
        beforeSend: function(){
            //Lo que se hace antes de enviar el formulario
            },
        success: function(respuesta){
            reg = registro.replace("TipoCalidad_idTipoCalidad", "", registro);
            $("#productoConformeTipoCalidad"+reg).val(respuesta[0]['noConformeTipoCalidad']);

            calcularTotalRecibo();
        },
        error:    function(xhr,err){ 
            alert("Error");
        }
    });
}

function imprimirFormato(idReciboCompra)
{
    window.open('recibocompra/'+idReciboCompra+'?idReciboCompra='+idReciboCompra+'&accion=imprimir','ordencompra','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}