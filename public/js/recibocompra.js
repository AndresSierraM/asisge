function validarFormulario(event)
{
    var route = "http://"+location.host+"/ordencompra";
    var token = $("#token").val();
    var dato0 = document.getElementById('idOrdenCompra').value;
    var dato1 = document.getElementById('sitioEntregaOrdenCompra').value;
    var dato2 = document.getElementById('fechaElaboracionOrdenCompra').value;
    var dato3 = document.getElementById('fechaEstimadaOrdenCompra').value;
    var dato4 = document.getElementById('Tercero_idProveedor').value;
    var dato5 = document.getElementById('estadoReciboOrdenCompra').value;
    
    var valor = '';
    var sw = true;
    

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idOrdenCompra: dato0,
                sitioEntregaOrdenCompra: dato1,
                fechaElaboracionOrdenCompra: dato2,
                fechaEstimadaOrdenCompra: dato3,
                Tercero_idProveedor: dato4,
                estadoReciboOrdenCompra: dato5
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

                (typeof msj.responseJSON.sitioEntregaOrdenCompra === "undefined" ? document.getElementById('sitioEntregaOrdenCompra').style.borderColor = '' : document.getElementById('sitioEntregaOrdenCompra').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaElaboracionOrdenCompra === "undefined" ? document.getElementById('fechaElaboracionOrdenCompra').style.borderColor = '' : document.getElementById('fechaElaboracionOrdenCompra').style.borderColor = '#a94442');

                (typeof msj.responseJSON.fechaEstimadaOrdenCompra === "undefined" ? document.getElementById('fechaEstimadaOrdenCompra').style.borderColor = '' : document.getElementById('fechaEstimadaOrdenCompra').style.borderColor = '#a94442');

                (typeof msj.responseJSON.Tercero_idProveedor === "undefined" ? document.getElementById('Tercero_idProveedor').style.borderColor = '' : document.getElementById('Tercero_idProveedor').style.borderColor = '#a94442');

                (typeof msj.responseJSON.estadoReciboOrdenCompra === "undefined" ? document.getElementById('estadoReciboOrdenCompra').style.borderColor = '' : document.getElementById('estadoReciboOrdenCompra').style.borderColor = '#a94442');
                
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

    estructuraTabla = '<div class="row" style="width:90%;">'+
                        '<div class="container" style="width:100%;">'+
                            '<table id="tordencompra" name="tordencompra" class="display table-bordered" width="100%">'+
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

    window.parent.$("#tordencompra tbody").on( "dblclick", "tr", function () 
    {
        if ( $(this).hasClass("selected") ) {
            $(this).removeClass("selected");
        }
        else {
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
        }

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
                var valores = new Array(respuesta[i]['idFichaTecnica'], respuesta[i]['referenciaFichaTecnica'], respuesta[i]['nombreFichaTecnica'], respuesta[i]['cantidadOrdenCompraProducto'], 0, '', respuesta[i]['valorUnitarioOrdenCompraProducto'], 0, 0, 0);
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

    calcularTotales();
    
}

function calcularTotales()
{
    total = 0;

    for (var i = 0; i < window.parent.producto.contador; i++) 
    {
        if(typeof $("#valorTotalReciboCompraProducto"+i, window.parent.document).val() != 'undefined' &&
            $("#valorTotalReciboCompraProducto"+i, window.parent.document).val() > 0)
        {
            total += parseFloat($("#valorTotalReciboCompraProducto"+i, window.parent.document).val());
        }
    }
            
    $('#totalProducto', window.parent.document).val(total);
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

            porc = 1-(parseFloat($("#diferenciaReciboCompraResultado"+i).val()) / parseFloat($("#valorCompraReciboCompraResultado"+i).val()));
            $("#porcentajeReciboCompraResultado"+i).val(porc);

            result = parseFloat($("#porcentajeReciboCompraResultado"+i).val()) - parseFloat($("#pesoReciboCompraResultado"+i).val());
            $("#resultadoReciboCompraResultado"+i).val(result);
        }
        // else if($("#descripcionReciboCompraResultado"+i).val() == 'Calidad')
        // {

        // }
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

            porc = 1-(parseFloat($("#diferenciaReciboCompraResultado"+i).val()) / parseFloat($("#valorCompraReciboCompraResultado"+i).val()));
            $("#porcentajeReciboCompraResultado"+i).val(porc);

            result = parseFloat($("#porcentajeReciboCompraResultado"+i).val()) - parseFloat($("#pesoReciboCompraResultado"+i).val());
            $("#resultadoReciboCompraResultado"+i).val(result);
        }
    }
}

function imprimirFormato(idOrdenCompra, idDocumentoCRM)
{
    window.open('ordencompra/'+idOrdenCompra+'?idDocumentoCRM='+idDocumentoCRM+'&accion=imprimir','ordencompra','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}