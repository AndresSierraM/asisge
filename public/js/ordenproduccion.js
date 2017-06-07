
$(document).ready(function(){ 

  
    //**************************
    // 
    //   P R O C E S O S
    //
    //**************************
    proceso = new Atributos('proceso','contenedor_proceso','proceso_');

    proceso.altura = '35px';
    proceso.campoid = 'idOrdenProduccionProceso';
    proceso.campoEliminacion = 'eliminarProceso';

    proceso.campos   = ['idOrdenProduccionProceso', 
                    'ordenOrdenProduccionProceso',
                    'Proceso_idProceso',
                    'nombreProceso',
                    'observacionOrdenProduccionProceso'];

    proceso.etiqueta = ['input','input', 'input','input','input'];
    proceso.tipo     = ['hidden','text', 'hidden','text','text'];
    proceso.estilo   = ['','width: 100px;height:35px;','','width: 400px;height:35px;','width: 400px;height:35px;'];
    proceso.clase    = ['','','','',''];      
    proceso.sololectura = [false,false,false,true,false];
    
    for(var j=0, k = procesos.length; j < k; j++)
    {
        proceso.agregarCampos(JSON.stringify(procesos[j]),'L');
       
    }

    //**************************
    // 
    //   M A T E R I A L E S 
    //
    //**************************
    material = new Atributos('material','contenedor_material','material_');

    material.altura = '35px';
    material.campoid = 'idOrdenProduccionMaterial';
    material.campoEliminacion = 'eliminarMaterial';
    material.botonEliminacion = false;

    material.campos   = ['idOrdenProduccionMaterial', 
                        'nombreOrdenProduccionMaterial', 
                        'consumoUnitarioOrdenProduccionMaterial', 
                        'consumoTotalOrdenProduccionMaterial'];

    material.etiqueta = ['input','input', 'input','input'];
    material.tipo     = ['hidden','text', 'text','text'];
    material.estilo   = ['','width: 500px;height:35px;','width: 200px;height:35px;','width: 200px;height:35px;'];
    material.clase    = ['','','','',''];      
    material.sololectura = [true,true,true,true,true];
    
    for(var j=0, k = materiales.length; j < k; j++)
    {
        material.agregarCampos(JSON.stringify(materiales[j]),'L');
    }

});

function cargarProcesos() 
{
    proceso.borrarTodosCampos();
    var id = document.getElementById('FichaTecnica_idFichaTecnica').value;
    if(id == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarFichaTecnicaProceso',
        data:{idFichaTecnica: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            
            // adicionamos los registros de procesos de la ficha tecnica a la orden de produccion
            for (var i = 0;  i <= data.length; i++) 
            {
                valores = Array(0, data[i]["ordenFichaTecnicaProceso"], data[i]["Proceso_idProceso"], data[i]["nombreProceso"], data[i]["observacionFichaTecnicaProceso"]);
                proceso.agregarCampos(valores,'A');
            }

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};

function cargarMateriales() 
{
    material.borrarTodosCampos();
    var id = document.getElementById('FichaTecnica_idFichaTecnica').value;
    var cantidadOP = document.getElementById('cantidadOrdenProduccion').value;
    if(id == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarFichaTecnicaMaterial',
        data:{idFichaTecnica: id,
                cantidadOP: cantidadOP},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            
            // adicionamos los registros de materiales de la ficha tecnica a la orden de produccion
            for (var i = 0;  i <= data.length; i++) 
            {
                valores = Array(0, data[i]["nombreOrdenProduccionMaterial"], data[i]["consumoUnitarioOrdenProduccionMaterial"], data[i]["consumoTotalOrdenProduccionMaterial"]);
                material.agregarCampos(valores,'A');
            }

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
};


// SELECT nombreFichaTecnicaMaterial, consumoFichaTecnicaMaterial, (consumoFichaTecnicaMaterial*cantidadOrdenProduccion) as consumoTotal
// FROM ordenproduccion OP 
// LEFT JOIN fichatecnicamaterial FTM
// ON OP.FichaTecnica_idFichaTecnica = FTM.FichaTecnica_idFichaTecnica
// WHERE idOrdenProduccion = 1


function abrirModalProceso()
{
    var lastIdx = null;
    window.parent.$("#tproceso").DataTable().ajax.url('http://'+location.host+"/datosProcesoSelect").load();
     // Abrir modal
    window.parent.$("#ModalProceso").modal()

    $("a.toggle-vis").on( "click", function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr("data-column") );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    window.parent.$("#tproceso tbody").on( "mouseover", "td", function () 
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
    window.parent.$("#tproceso tfoot th").each( function () 
    {
        var title = window.parent.$("#tproceso thead th").eq( $(this).index() ).text();
        $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
    });
 
    // DataTable
    var table = window.parent.$("#tproceso").DataTable();
 
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

    window.parent.$('#tproceso tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');

        var datos = table.rows('.selected').data();


    } );

    window.parent.$('#botonCampo').click(function() {
        var datos = table.rows('.selected').data();  
        
        

        for (var i = 0; i < datos.length; i++) 
        {
            var valores = new Array(0, '', datos[i][0],datos[i][2],'');
            window.parent.proceso.agregarCampos(valores,'A'); 

            
            
        }
        
        


        window.parent.$("#ModalProceso").modal("hide");
    });

}


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
