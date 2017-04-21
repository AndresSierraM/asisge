
$(document).ready(function(){ 

    $("div#tabsMaterial").tabs();
    $("div#tabsOperacion").tabs();

    proceso = new Atributos('proceso','contenedor_proceso','proceso_');

    proceso.altura = '35px';
    proceso.campoid = 'idFichaTecnicaProceso';
    proceso.campoEliminacion = 'eliminarProceso';

    proceso.campos   = ['idFichaTecnicaProceso', 
                    'ordenFichaTecnicaProceso',
                    'Proceso_idProceso',
                    'nombreProceso',
                    'observacionFichaTecnicaProceso'];

    proceso.etiqueta = ['input','input', 'input','input','input'];
    proceso.tipo     = ['hidden','text', 'hidden','text','text'];
    proceso.estilo   = ['','width: 100px;height:35px;','','width: 400px;height:35px;','width: 400px;height:35px;'];
    proceso.clase    = ['','','','',''];      
    proceso.sololectura = [false,false,false,false,false];
    
    for(var j=0, k = procesos.length; j < k; j++)
    {
        proceso.agregarCampos(JSON.stringify(procesos[j]),'L');
        adicionarTabMaterial(procesos[j]["Proceso_idProceso"], procesos[j]["nombreProceso"], materiales);
        adicionarTabOperacion(procesos[j]["Proceso_idProceso"], procesos[j]["nombreProceso"], operaciones);
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

    window.parent.$('#botonCampo').click(function() {
        var datos = table.rows('.selected').data();  
        
        

        for (var i = 0; i < datos.length; i++) 
        {
            var valores = new Array(0, '', datos[i][0],datos[i][2],'');
            window.parent.proceso.agregarCampos(valores,'A'); 

            adicionarTabMaterial(datos[i][0], datos[i][2], materiales);

            adicionarTabOperacion(datos[i][0], datos[i][2], operaciones);
            
            
        }
        
        


        window.parent.$("#ModalProceso").modal("hide");
    });

}

function adicionarTabMaterial(idTab, nombreTab, datos)
{
    $("div#tabsMaterial ul").append(
        '<li class="active"><a data-toggle="tab" href="#tab' + idTab + '">' + nombreTab + '</a></li>'
    );

    $("div#tabsMaterial").append(
        '<div id="tab' + idTab + '" class="tab-pane fade in active">'+
            '<div class="form-group">'+
            '    <div class="col-sm-12">'+
            '        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">'+
            '            <div style="overflow:auto; height:350px;">'+
            '                <div style="width: 100%; display: inline-block;">'+
            '                    <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="material['+idTab+'].agregarCampos([\'\',\'\',\''+idTab+'\',\'0.0000\',\'\'], \'A\');">'+
            '                      <span class="glyphicon glyphicon-plus"></span>'+
            '                    </div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Material</div>'+
            '                    <div class="col-md-1" style="width: 200px;" >Consumo Unit</div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Observaciones</div>'+
            '                    <div id="contenedor_material'+idTab+'">'+
            '                    </div>'+
            '                </div>'+
            '            </div>'+
            '        </div>'+
            '    </div>'+
            '</div>'+
        '</div>');

    $("div#tabsMaterial").tabs("refresh");


    material[idTab] = new Atributos('material['+idTab+']','contenedor_material'+idTab,'material'+idTab+'_');

    material[idTab].altura = '35px';
    material[idTab].campoid = 'idFichaTecnicaMaterial';
    material[idTab].campoEliminacion = 'eliminarMaterial';

    material[idTab].campos   = ['idFichaTecnicaMaterial', 
                                'nombreFichaTecnicaMaterial',
                                'Proceso_idMaterial', 
                                'consumoFichaTecnicaMaterial', 
                                'observacionFichaTecnicaMaterial'];

    material[idTab].etiqueta = ['input','input', 'input','input','input'];
    material[idTab].tipo     = ['hidden','text', 'hidden','text','text'];
    material[idTab].estilo   = ['','width: 400px;height:35px;','','width: 200px;height:35px; text-align:right;','width: 400px;height:35px;'];
    material[idTab].clase    = ['','','','',''];      
    material[idTab].sololectura = [false,false,false,false,false];

    // luego de creada la estructra, adicionamos los datos que estan actualmente en la BD, solo los que pertenezcan al proceso actual
    for(var j=0, k = datos.length; j < k; j++)
    {
        if(datos[j]['Proceso_idMaterial'] == idTab)
            material[idTab].agregarCampos(JSON.stringify(datos[j]),'L');
        
    }
    

}



function adicionarTabOperacion(idTab, nombreTab, datos)
{
    $("div#tabsOperacion ul").append(
        '<li class="active"><a data-toggle="tab" href="#tab' + idTab + '">' + nombreTab + '</a></li>'
    );

    $("div#tabsOperacion").append(
        '<div id="tab' + idTab + '" class="tab-pane fade in active">'+
            '<div class="form-group">'+
            '    <div class="col-sm-12">'+
            '        <div class="row show-grid" style=" border: 1px solid #C0C0C0;">'+
            '            <div style="overflow:auto; height:350px;">'+
            '                <div style="width: 100%; display: inline-block;">'+
            '                    <div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="operacion['+idTab+'].agregarCampos([\'0\',\''+idTab+'\',\'0\',\'\',\'0.0000\',\'\'], \'A\');">'+
            '                      <span class="glyphicon glyphicon-plus"></span>'+
            '                    </div>'+
            '                    <div class="col-md-1" style="width: 100px;" >Orden</div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Operacion</div>'+
            '                    <div class="col-md-1" style="width: 100px;" >SAM</div>'+
            '                    <div class="col-md-1" style="width: 400px;" >Observaciones</div>'+
            '                    <div id="contenedor_operacion'+idTab+'">'+
            '                    </div>'+
            '                </div>'+
            '            </div>'+
            '        </div>'+
            '    </div>'+
            '</div>'+
        '</div>');

    $("div#tabsOperacion").tabs("refresh");


    operacion[idTab] = new Atributos('operacion['+idTab+']','contenedor_operacion'+idTab,'operacion'+idTab+'_');

    operacion[idTab].altura = '35px';
    operacion[idTab].campoid = 'idFichaTecnicaOperacion';
    operacion[idTab].campoEliminacion = 'eliminarOperacion';

    operacion[idTab].campos   = ['idFichaTecnicaOperacion', 
                                'Proceso_idOperacion', 
                                'ordenFichaTecnicaOperacion',
                                'nombreFichaTecnicaOperacion',
                                'samFichaTecnicaOperacion', 
                                'observacionFichaTecnicaOperacion'];

    operacion[idTab].etiqueta = ['input','input', 'input','input','input','input'];
    operacion[idTab].tipo     = ['hidden', 'hidden','text','text','text','text'];
    operacion[idTab].estilo   = ['','','width: 100px;height:35px; text-align:right;','width: 400px;height:35px;','width: 100px;height:35px; text-align:right;','width: 400px;height:35px;'];
    operacion[idTab].clase    = ['','','','','',''];      
    operacion[idTab].sololectura = [false,false,false,false,false,false];

    // luego de creada la estructura, adicionamos los datos que estan actualmente en la BD, solo los que pertenezcan al proceso actual
    for(var j=0, k = datos.length; j < k; j++)
    {
        if(datos[j]['Proceso_idOperacion'] == idTab)
            operacion[idTab].agregarCampos(JSON.stringify(datos[j]),'L');
        
    }
    

}


function habilitarSubmit(event)
{
    event.preventDefault();
    

    validarformulario();
}

function validarformulario()
{
    var resp = true;
    // Validamos los datos de detalle
    for(actual = 0; actual < document.getElementById('registros').value ; actual++)
    {
        if(document.getElementById("Tercero_idResponsable"+(actual)) && 
           document.getElementById("accionMejoraInspeccionDetalle"+(actual)).value != '' && document.getElementById("Tercero_idResponsable"+(actual)).value == 0)
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "vertical-align:top; resize:none; width: 200px; height:60px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "vertical-align:top; resize:none; width: 200px; height:60px; background-color:white;";
        } 
    }

    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique los campos resaltados en rojo, deben ser diligenciados');
    }

    return true;
}

