function llamarsublinea(id, valor) 
{   
    //Se toma por medio de Id el de la linea selccionada
    var select = document.getElementById('LineaProducto_idLineaProducto').value;
    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'http://'+location.host+'/llamarsublinea', /*Funcion para ejecutar  el Ajax para que consulte en la BD la tabla de sublineas */
        data:{idLineaProducto: id}, // Este id lo envia por get para el ajax
        type:  'get',   
        beforeSend: function(){},
        success: function(data)
        {
            /* cuando reciba la consulta, va a tomar el nombre de la lista de sublineas*/
            $('#SublineaProducto_idSublineaProducto').html('');
            var select = document.getElementById('SublineaProducto_idSublineaProducto');
            /*Recibe el nombre hasta aca*/
            // Estas Option se utilizan para que agregue una primera opcion que diga seleccione 
            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione';
            select.appendChild(option);
            //Recorre los registros de sublineas para irlos  creando como opciones en esa lista
            for (var i = 0;  i <= data.length; i++) 
            {

                option = document.createElement('option');
                option.value = data[i]['idSublineaProducto'];
                option.text = data[i]['nombreSublineaProducto'];

                option.selected = (valor == data[i]['idSublineaProducto'] ? true : false);

                select.appendChild(option);
            }



        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: ' +err);
        }
    });
};


var AtributosNota = function(nombreObjeto, nombreContenedor, nombreDiv){
    this.alto = '100px;';
    this.ancho = '100%;';
    this.campoid = 'idFichaTecnicaNota';
    this.campoEliminacion = 'eliminarNota';
    this.botonEliminacion = true;

    this.nombre = nombreObjeto;
    this.contenedor = nombreContenedor;
    this.contenido = nombreDiv;
    this.contador = 0;
};

AtributosNota.prototype.agregarNota = function(datos, tipo){

    var valor;
    if(tipo == 'A')
       valor = datos;
    else
        valor = $.parseJSON(datos);
    
    var espacio = document.getElementById(this.contenedor);
   
    var div = document.createElement('div');
    div.id = this.contenido+this.contador;
    div.setAttribute("class", "col-sm-12");
    div.setAttribute("style",  "overflow: auto; background: transparent; height:"+this.alto+"width:"+this.ancho+";margin: 3px 3px 3px 3px; padding: 2px 2px 2px 2px;");
    
    // si esta habilitado el parametro de eliminacion de registros del detalle, adicionamos la caneca
    if(this.botonEliminacion && tipo == 'A')
    {
        var img = document.createElement('i');
        var caneca = document.createElement('div');
        caneca.id = 'eliminarRegistro'+ this.contador;
        caneca.setAttribute('onclick',this.nombre+'.borrarCampos(\''+div.id+'\',\''+this.campoEliminacion+'\',\''+this.campoid+this.contador+'\')');
        caneca.setAttribute("class","canecaNota col-md-1");
        caneca.setAttribute("style","");
        img.setAttribute("class","glyphicon glyphicon-trash");

        caneca.appendChild(img);
        div.appendChild(caneca);
    }

    
    //--------------------
    // id de la Nota
    //--------------------
    var input = document.createElement('input');
    input.type =  "hidden";
    input.id =  "idFichaTecnicaNota" + this.contador;
    input.name =  "idFichaTecnicaNota[]";
    input.value = valor[(tipo == 'A' ? 0 : "idFichaTecnicaNota")] ;
    input.setAttribute("class", "");
    input.readOnly = "";
    input.autocomplete = "false";
    div.appendChild(input);

    //--------------------
    // id de usuario
    //--------------------
    var input = document.createElement('input');
    input.type =  "hidden";
    input.id =  "Users_idUsuario" + this.contador;
    input.name =  "Users_idUsuario[]";
    input.value = valor[(tipo == 'A' ? 1 : "Users_idUsuario")] ;
    input.setAttribute("class", "");
    input.readOnly = "";
    input.autocomplete = "false";
    div.appendChild(input);

    //--------------------
    // Nombre de usuario
    //--------------------
    var input = document.createElement('input');
    input.type =  "text";
    input.id =  "nombreUsuario" + this.contador;
    input.name =  "nombreUsuario[]";
    input.value = 'Escrito por: '+valor[(tipo == 'A' ? 2 : "nombreUsuario")] ;
    input.setAttribute("class", "nombreUsuarioNota");
    input.readOnly = "readOnly";
    input.autocomplete = "false";
    div.appendChild(input);

    //--------------------
    // fecha elaboración
    //--------------------
    var input = document.createElement('input');
    input.type =  "text";
    input.id =  "fechaFichaTecnicaNota" + this.contador;
    input.name =  "fechaFichaTecnicaNota[]";
    input.value = valor[(tipo == 'A' ? 3 : "fechaFichaTecnicaNota")] ;
    input.setAttribute("class", "fechaNota");
    input.readOnly = "readOnly";
    input.autocomplete = "false";
    div.appendChild(input);

    //--------------------
    // Texto de la Nota
    //--------------------
    var input = document.createElement('textarea');
    input.id =  "observacionFichaTecnicaNota" + this.contador;
    input.name =  "observacionFichaTecnicaNota[]";
    input.placeholder =  "Descripción";
    input.value = valor[(tipo == 'A' ? 4 : "observacionFichaTecnicaNota")] ;
    input.setAttribute("class", "textoNota");
    input.readOnly = (tipo == 'L' ? "readOnly" : '');
    input.autocomplete = "false";
    div.appendChild(input);

    

 
       
    espacio.appendChild(div);

    this.contador++;
}

AtributosNota.prototype.borrarCampos = function(elemento, campoEliminacion, campoid){
   
    if(campoEliminacion && document.getElementById(campoEliminacion) && document.getElementById(campoid))
        document.getElementById(campoEliminacion).value += document.getElementById(campoid).value + ',';

    // aux = elemento.parentNode;
    // alert(aux);
    // if(aux );
        $("#"+elemento).remove();

}

AtributosNota.prototype.borrarTodosCampos = function(){
    
    
    for (var posborrar = 0 ; posborrar < this.contador; posborrar++) 
    {
        this.borrarCampos(this.contenido+posborrar, this.campoEliminacion, this.campoid+this.contador);
    }
    this.contador = 0;
}


$(document).ready(function(){ 
// Se crea la variable para cuando la sublinea ya exista
sublineas = "<?php echo @$sublineaproducto->LineaProducto_idLineaProducto;?>";
if ($("#LineaProducto_idLineaProducto").length > 0  && $("#LineaProducto_idLineaProducto").val() !== '') 
{
    llamarsublinea($("#LineaProducto_idLineaProducto").val(),sublinea);
}



    $("div#tabsMaterial").tabs();
    $("div#tabsOperacion").tabs();

    //**************************
    // 
    //   P R O C E S O S
    //
    //**************************
    proceso = new Atributos('proceso','contenedor_proceso','proceso_');

    proceso.altura = '35px';
    proceso.campoid = 'idFichaTecnicaProceso';
    proceso.campoEliminacion = 'eliminarProceso';
    proceso.funcionEliminacion = 'eliminarTabMaterial';

    proceso.campos   = ['idFichaTecnicaProceso', 
                    'ordenFichaTecnicaProceso',
                    'Proceso_idProceso',
                    'nombreProceso',
                    'observacionFichaTecnicaProceso'];

    proceso.etiqueta = ['input','input', 'input','input','input'];
    proceso.tipo     = ['hidden','text', 'hidden','text','text'];
    proceso.estilo   = ['','width: 100px;height:35px;','','width: 400px;height:35px;','width: 400px;height:35px;'];
    proceso.clase    = ['','','','',''];      
    proceso.sololectura = [false,false,false,true,false];
    
    for(var j=0, k = procesos.length; j < k; j++)
    {
        proceso.agregarCampos(JSON.stringify(procesos[j]),'L');
        adicionarTabMaterial(j, procesos[j]["Proceso_idProceso"], procesos[j]["nombreProceso"], materiales);
        adicionarTabOperacion(j, procesos[j]["Proceso_idProceso"], procesos[j]["nombreProceso"], operaciones);
    }


    //**************************
    // 
    //   N O T A S 
    //
    //**************************
    nota = new AtributosNota('nota','contenedor_nota','nota_');

    nota.alto = '100px;';
    nota.ancho = '100%;';
    nota.campoid = 'idFichaTecnicaNota';
    nota.campoEliminacion = 'eliminarNota';

    for(var j=0, k = notas.length; j < k; j++)
    {
        nota.agregarNota(JSON.stringify(notas[j]),'L');
    }

    //**************************
    // 
    //   C R I T E R I O
    //
    //**************************
    criterio = new Atributos('criterio','contenedor_criterio','criterio_');

    criterio.altura = '35px';
    criterio.campoid = 'idFichaTecnicaCriterio';
    criterio.campoEliminacion = 'eliminarCriterio';

    criterio.campos   = ['idFichaTecnicaCriterio', 
                    'descripcionFichaTecnicaCriterio',
                    'FichaTecnica_idFichaTecnica'];

    criterio.etiqueta = ['input','input', 'input'];
    criterio.tipo     = ['hidden','text', 'hidden'];
    criterio.estilo   = ['','width: 900px;height:35px;',''];
    criterio.clase    = ['','',''];      
    criterio.sololectura = [true,false,true];
    
    for(var j=0, k = criterios.length; j < k; j++)
    {
        criterio.agregarCampos(JSON.stringify(criterios[j]),'L');
    }

});


function abrirModalProceso(materiales, operaciones)
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

    window.parent.$('#botonProceso').click(function() {
        var datos = table.rows('.selected').data();  
        
        

        for (var i = 0; i < datos.length; i++) 
        {
            var valores = new Array(0, '', datos[i][0],datos[i][2],'');
            window.parent.proceso.agregarCampos(valores,'A'); 

            adicionarTabMaterial(i, datos[i][0], datos[i][2], materiales);

            adicionarTabOperacion(i, datos[i][0], datos[i][2], operaciones);
            
            
        }
        
        


        window.parent.$("#ModalProceso").modal("hide");
    });

}

function abrirModalMaterial(cont, idProceso)
{
    var lastIdx = null;
    window.parent.$("#tmaterial").DataTable().ajax.url('http://'+location.host+"/datosMaterialSelect").load();
     // Abrir modal
    window.parent.$("#ModalMaterial").modal()

    $("a.toggle-vis").on( "click", function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr("data-column") );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );

    window.parent.$("#tmaterial tbody").on( "mouseover", "td", function () 
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
    window.parent.$("#tmaterial tfoot th").each( function () 
    {
        var title = window.parent.$("#tmaterial thead th").eq( $(this).index() ).text();
        $(this).html( "<input type='text' placeholder='Buscar por "+title+"'/>" );
    });
 
    // DataTable
    var table = window.parent.$("#tmaterial").DataTable();
 
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

    window.parent.$('#tmaterial tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');

        var datos = table.rows('.selected').data();


    } );

    window.parent.$('#botonMaterial').click(function() {
        var datos = table.rows('.selected').data();  

        for (var i = 0; i < datos.length; i++) 
        {
            var valores = new Array(0, datos[i][0],datos[i][1],datos[i][2],idProceso, 0, '');
            window.parent.material[cont].agregarCampos(valores,'A'); 

        }

        window.parent.$("#ModalMaterial").modal("hide");
    });

}

function adicionarTabMaterial(cont, idTab, nombreTab, datos)
{
    $("div#tabsMaterial ul").append(
        '<li class="active"><a data-toggle="tab" href="#TabMat' + cont + '">' + nombreTab + '</a></li>'
    );

    $("div#tabsMaterial").append(
        '<div id="TabMat' + cont + '" class="tab-pane fade in active">'+
            '<div class="form-group">'+
            '    <div class="col-sm-12">'+
            '        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">'+
            '            <div style="overflow:auto; height:350px;">'+
            '                <div style="width: 100%; display: inline-block;">'+
            '                    <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="abrirModalMaterial('+cont+','+idTab+');">'+
            '                      <span class="glyphicon glyphicon-plus"></span>'+
            '                    </div>'+
            '                    <div class="col-md-1" style="width: 150px;" >Referencia</div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Nombre Material</div>'+ 
            '                    <div class="col-md-1" style="width: 100px;" >Consumo</div>'+
            '                    <div class="col-md-1" style="width: 300px;" >Observaciones</div>'+
            '                    <div id="contenedor_material'+cont+'">'+
            '                    </div>'+
            '                </div>'+
            '            </div>'+
            '        </div>'+
            '    </div>'+
            '</div>'+
        '</div>');

    $("div#tabsMaterial").tabs("refresh");


    material[cont] = new Atributos('material['+cont+']','contenedor_material'+cont,'material'+cont+'_');

    material[cont].altura = '35px';
    material[cont].campoid = 'idFichaTecnicaMaterial';
    material[cont].campoEliminacion = 'eliminarMaterial';

    material[cont].campos   = ['idFichaTecnicaMaterial', 
                                'FichaTecnica_idMaterial',
                                'referenciaFichaTecnicaMaterial',
                                'nombreFichaTecnicaMaterial',
                                'Proceso_idMaterial', 
                                'consumoFichaTecnicaMaterial', 
                                'observacionFichaTecnicaMaterial'];

    material[cont].etiqueta = ['input','input','input','input', 'input','input','input'];
    material[cont].tipo     = ['hidden','hidden','text','text', 'hidden','text','text'];
    material[cont].estilo   = ['','','width: 150px;height:35px;','width: 400px;height:35px;','','width: 100px;height:35px; text-align:right;','width: 300px;height:35px;'];
    material[cont].clase    = ['','','','','','',''];      
    material[cont].sololectura = [false,false,true,true,false,false,false];

    // luego de creada la estructra, adicionamos los datos que estan actualmente en la BD, solo los que pertenezcan al proceso actual
    for(var j=0, k = datos.length; j < k; j++)
    {
        if(datos[j]['Proceso_idMaterial'] == idTab)
            material[cont].agregarCampos(JSON.stringify(datos[j]),'L');
        
    }
    

}

function eliminarTabMaterial(cont) {
    var tabIdStr = "#TabMat" + cont

    // Eliminamos los registros para que queden en la variable de ids eliminados
    // for (var posborrar = 0 ; posborrar < material[cont].contador; posborrar++) 
    // {
    //     material[cont].borrarCampos(material[cont].contenido + posborrar, material[cont].campoEliminacion, material[cont].campoid + material[cont].contador);
    // }
    material[cont].contador = 0;

    // Elimina el panel
    $( tabIdStr ).remove();
    // refresca las pestañas
    //tabs.tabs( "refresh" );

    // Elimina la pestaña
    var hrefStr = "a[href='" + tabIdStr + "']"
    $( hrefStr ).closest("li").remove()
}


function adicionarTabOperacion(cont, idTab, nombreTab, datos)
{
    
    $("div#tabsOperacion ul").append(
        '<li class="active"><a data-toggle="tab" href="#tab' + cont + '">' + nombreTab + '</a></li>'
    );

    $("div#tabsOperacion").append(
        '<div id="tab' + cont + '" class="tab-pane fade in active">'+
            '<div class="form-group">'+
            '    <div class="col-sm-12">'+
            '        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">'+
            '            <div style="overflow:auto; height:350px;">'+
            '                <div style="width: 100%; display: inline-block;">'+
            '                    <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="operacion['+cont+'].agregarCampos([\'0\',\''+idTab+'\',\'0\',\'\',\'0.0000\',\'\'], \'A\');">'+
            '                      <span class="glyphicon glyphicon-plus"></span>'+
            '                    </div>'+
            '                    <div class="col-md-1" style="width: 100px;" >Orden</div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Operacion</div>'+
            '                    <div class="col-md-1" style="width: 100px;" >SAM</div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Observaciones</div>'+
            '                    <div id="contenedor_operacion'+cont+'">'+
            '                    </div>'+
            '                </div>'+
            '            </div>'+
            '        </div>'+
            '    </div>'+
            '</div>'+
        '</div>');

    $("div#tabsOperacion").tabs("refresh");


    operacion[cont] = new Atributos('operacion['+cont+']','contenedor_operacion'+cont,'operacion'+cont+'_');

    operacion[cont].altura = '35px';
    operacion[cont].campoid = 'idFichaTecnicaOperacion';
    operacion[cont].campoEliminacion = 'eliminarOperacion';

    operacion[cont].campos   = ['idFichaTecnicaOperacion', 
                                'Proceso_idOperacion', 
                                'ordenFichaTecnicaOperacion',
                                'nombreFichaTecnicaOperacion',
                                'samFichaTecnicaOperacion', 
                                'observacionFichaTecnicaOperacion'];

    operacion[cont].etiqueta = ['input','input', 'input','input','input','input'];
    operacion[cont].tipo     = ['hidden', 'hidden','text','text','text','text'];
    operacion[cont].estilo   = ['','','width: 100px;height:35px; text-align:right;','width: 400px;height:35px;','width: 100px;height:35px; text-align:right;','width: 400px;height:35px;'];
    operacion[cont].clase    = ['','','','','',''];      
    operacion[cont].sololectura = [false,false,false,false,false,false];

    // luego de creada la estructura, adicionamos los datos que estan actualmente en la BD, solo los que pertenezcan al proceso actual
    for(var j=0, k = datos.length; j < k; j++)
    {
        if(datos[j]['Proceso_idOperacion'] == idTab)
            operacion[cont].agregarCampos(JSON.stringify(datos[j]),'L');
        
    }
    

}


function eliminarDiv(idDiv)
{
    eliminar=confirm("¿Deseas eliminar este archivo?");
    if (eliminar)
    {
        $("#"+idDiv ).remove();  
        $("#eliminarArchivo").val( $("#eliminarArchivo").val() + idDiv + ",");  
    }
}


function validarFormulario(event)
{
    
    var route = "http://"+location.host+"/fichatecnica";
    var token = $("#token").val();

    var dato = document.getElementById('idFichaTecnica').value;
    var dato0 = document.getElementById('referenciaFichaTecnica').value;
    var dato1 = document.getElementById('nombreFichaTecnica').value;
    var dato2 = document.getElementById('LineaProducto_idLineaProducto').value;

    var datoOrden = document.querySelectorAll("[name='ordenFichaTecnicaProceso[]']");
    var datoProc = document.querySelectorAll("[name='nombreProceso[]']");
    var datoNota = document.querySelectorAll("[name='observacionFichaTecnicaNota[]']");
   
    var dato3 = [];
    var dato4 = [];
    var dato5 = [];
  
   

    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoOrden.length; j<i;j++)
    {
        dato3[j] = datoOrden[j].value;
    }

    
    for(var j=0,i=datoProc.length; j<i;j++)
    {
        dato4[j] = datoProc[j].value;
    }

    for(var j=0,i=datoNota.length; j<i;j++)
    {
        dato5[j] = datoNota[j].value;
    }

    

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idFichaTecnica: dato,
                referenciaFichaTecnica: dato0,
                nombreFichaTecnica: dato1,
                LineaProducto_idLineaProducto: dato2,

                ordenFichaTecnicaProceso : dato3, 
                nombreProceso: dato4, 
                observacionFichaTecnicaNota: dato5
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
                
                (typeof msj.responseJSON.referenciaFichaTecnica === "undefined" ? document.getElementById('referenciaFichaTecnica').style.borderColor = '' : document.getElementById('referenciaFichaTecnica').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreFichaTecnica === "undefined" ? document.getElementById('nombreFichaTecnica').style.borderColor = '' : document.getElementById('nombreFichaTecnica').style.borderColor = '#a94442');

                (typeof msj.responseJSON.LineaProducto_idLineaProducto === "undefined" ? document.getElementById('LineaProducto_idLineaProducto').style.borderColor = '' : document.getElementById('LineaProducto_idLineaProducto').style.borderColor = '#a94442');
        
                for(var j=0,i=datoProc.length; j<i;j++)
                {
                    (typeof respuesta['ordenFichaTecnicaProceso'+j] === "undefined" 
                        ? document.getElementById('ordenFichaTecnicaProceso'+j).style.borderColor = '' 
                        : document.getElementById('ordenFichaTecnicaProceso'+j).style.borderColor = '#a94442');

                    (typeof respuesta['nombreProceso'+j] === "undefined" 
                        ? document.getElementById('nombreProceso'+j).style.borderColor = '' 
                        : document.getElementById('nombreProceso'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoNota.length; j<i;j++)
                {
                    (typeof respuesta['observacionFichaTecnicaNota'+j] === "undefined" 
                        ? document.getElementById('observacionFichaTecnicaNota'+j).style.borderColor = '' 
                        : document.getElementById('observacionFichaTecnicaNota'+j).style.borderColor = '#a94442');
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

