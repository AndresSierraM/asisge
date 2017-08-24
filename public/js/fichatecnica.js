function validarFormulario(event)
{

    if( !$.trim( $('#contenedor_color').html() ).length )
    {
        alert('Debe ingresar al menos un registro de un color en la pestaña de variantes.');
        return;
    }

    if( !$.trim( $('#contenedor_talla').html() ).length )
    {
        alert('Debe ingresar al menos un registro de una talla en la pestaña de variantes.');
        return;
    }


    var route = "http://"+location.host+"/fichatecnica";
    var token = $("#token").val();
    var dato0 = document.getElementById('idFichaTecnica').value;
    var dato1 = document.getElementById('referenciaBaseFichaTecnica').value;
    var dato2 = document.getElementById('pesoNetoFichaTecnica').value;
    var dato3 = document.getElementById('cantidadContenidaFichaTecnica').value;
    var dato4 = document.getElementById('GrupoTalla_idGrupoTalla').value;
    var dato5 = document.getElementById('TipoProducto_idTipoProducto').value;
    var dato6 = document.getElementById('TipoNegocio_idTipoNegocio').value;
    var dato7 = document.getElementById('nombreLargoFichaTecnica').value;
    var datoColor = document.querySelectorAll("[name='Color_idColor[]']");
    var datoCantidadColor = document.querySelectorAll("[name='cantidadFichaTecnicaColor[]']");
    var datoTalla = document.querySelectorAll("[name='Talla_idTalla[]']");
    var datoCurvaTalla = document.querySelectorAll("[name='curvaFichaTecnicaTalla[]']");
    var dato8 = [];
    var dato9 = [];
    var dato10 = [];
    var dato11 = [];

    for(var j=0,i=datoColor.length; j<i;j++)
    {
        dato8[j] = datoColor[j].value;
    }

    for(var j=0,i=datoCantidadColor.length; j<i;j++)
    {
        dato9[j] = datoCantidadColor[j].value;
    }

    for(var j=0,i=datoTalla.length; j<i;j++)
    {
        dato10[j] = datoTalla[j].value;
    }

    for(var j=0,i=datoCurvaTalla.length; j<i;j++)
    {
        dato11[j] = datoCurvaTalla[j].value;
    }
    
    var valor = '';
    var sw = true;
    
    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idFichaTecnica: dato0,
                referenciaBaseFichaTecnica: dato1,
                pesoNetoFichaTecnica: dato2,
                cantidadContenidaFichaTecnica: dato3,
                GrupoTalla_idGrupoTalla: dato4,
                TipoProducto_idTipoProducto: dato5,
                TipoNegocio_idTipoNegocio: dato6,
                nombreLargoFichaTecnica: dato7,
                Color_idColor: dato8,
                cantidadFichaTecnicaColor: dato9,
                Talla_idTalla: dato10,
                curvaFichaTecnicaTalla: dato11,
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

                guardarFichaTecnica();
            }
            else
            {
                sw = true;
                respuesta = JSON.parse(respuesta);

                (typeof msj.responseJSON.referenciaBaseFichaTecnica === "undefined" ? document.getElementById('referenciaBaseFichaTecnica').style.borderColor = '' : document.getElementById('referenciaBaseFichaTecnica').style.borderColor = '#a94442');

                (typeof msj.responseJSON.pesoNetoFichaTecnica === "undefined" ? document.getElementById('pesoNetoFichaTecnica').style.borderColor = '' : document.getElementById('pesoNetoFichaTecnica').style.borderColor = '#a94442');

                (typeof msj.responseJSON.cantidadContenidaFichaTecnica === "undefined" ? document.getElementById('cantidadContenidaFichaTecnica').style.borderColor = '' : document.getElementById('cantidadContenidaFichaTecnica').style.borderColor = '#a94442');

                (typeof msj.responseJSON.GrupoTalla_idGrupoTalla === "undefined" ? document.getElementById('GrupoTalla_idGrupoTalla').style.borderColor = '' : document.getElementById('GrupoTalla_idGrupoTalla').style.borderColor = '#a94442');

                (typeof msj.responseJSON.TipoProducto_idTipoProducto === "undefined" ? document.getElementById('TipoProducto_idTipoProducto').style.borderColor = '' : document.getElementById('TipoProducto_idTipoProducto').style.borderColor = '#a94442');

                (typeof msj.responseJSON.TipoNegocio_idTipoNegocio === "undefined" ? document.getElementById('TipoNegocio_idTipoNegocio').style.borderColor = '' : document.getElementById('TipoNegocio_idTipoNegocio').style.borderColor = '#a94442');

                (typeof msj.responseJSON.nombreLargoFichaTecnica === "undefined" ? document.getElementById('nombreLargoFichaTecnica').style.borderColor = '' : document.getElementById('nombreLargoFichaTecnica').style.borderColor = '#a94442');

                for(var j=0,i=datoColor.length; j<i;j++)
                {
                    (typeof respuesta['Color_idColor'+j] === "undefined" 
                        ? document.getElementById('Color_idColor'+j).style.borderColor = '' 
                        : document.getElementById('Color_idColor'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoCantidadColor.length; j<i;j++)
                {
                    (typeof respuesta['cantidadFichaTecnicaColor'+j] === "undefined" 
                        ? document.getElementById('cantidadFichaTecnicaColor'+j).style.borderColor = '' 
                        : document.getElementById('cantidadFichaTecnicaColor'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoTalla.length; j<i;j++)
                {
                    (typeof respuesta['Talla_idTalla'+j] === "undefined" 
                        ? document.getElementById('Talla_idTalla'+j).style.borderColor = '' 
                        : document.getElementById('Talla_idTalla'+j).style.borderColor = '#a94442');
                }

                for(var j=0,i=datoCurvaTalla.length; j<i;j++)
                {
                    (typeof respuesta['curvaFichaTecnicaTalla'+j] === "undefined" 
                        ? document.getElementById('curvaFichaTecnicaTalla'+j).style.borderColor = '' 
                        : document.getElementById('curvaFichaTecnicaTalla'+j).style.borderColor = '#a94442');
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

$(document).ready(function(){ 

  
    //**************************
    // 
    //   C O L O R E S
    //
    //**************************
    color = new Atributos('color','contenedor_color','color_');

    color.altura = '30px;';
    color.campoid = 'idFichaTecnicaColor';
    color.campoEliminacion = 'eliminarColor';

    color.campos   = ['idFichaTecnicaColor', 
                    'Color_idColor',
                    'nombreEspecialFichaTecnicaColor',
                    'cantidadFichaTecnicaColor'];

    color.etiqueta = ['input','select', 'input','input'];
    color.tipo     = ['hidden','','text','text'];
    color.estilo   = ['','width:250px;','width:200px;display: inline-block;','width:150px; text-align: right; display: inline-block;'];
    color.clase    = ['','chosen-select','',''];      
    color.sololectura = [false,false,false,false];
    color.opciones = ['',maestrocolor,'',''];
    
    
    for(var j=0, k = fichacolor.length; j < k; j++)
    {
        color.agregarCampos(JSON.stringify(fichacolor[j]),'L');
       
    }

    
    //**************************
    // 
    //   T A L L A S
    //
    //**************************
    talla = new Atributos('talla','contenedor_talla','talla_');

    talla.altura = '30px;';
    talla.campoid = 'idFichaTecnicaTalla';
    talla.campoEliminacion = 'eliminarTalla';

    talla.campos   = ['idFichaTecnicaTalla', 
                    'Talla_idTalla',
                    'BaseMedidaFichaTecnicaTalla',
                    'curvaFichaTecnicaTalla'];

    talla.etiqueta = ['input','select', 'checkbox','input'];
    talla.tipo     = ['hidden','','checkbox','text'];
    talla.estilo   = ['','width:300px;','width:100px;text-align: center; display: inline-block;','width:100px;text-align: right; display: inline-block;'];
    talla.clase    = ['','col-md-5','col-md-3','col-md-3'];      
    talla.sololectura = [false,false,false,false];
    talla.opciones = ['',maestrotalla,'',''];
    
    
    for(var j=0, k = fichatalla.length; j < k; j++)
    {
        talla.agregarCampos(JSON.stringify(fichatalla[j]),'L');
    }


    //**************************
    // 
    //   COMPOSICION
    //
    //**************************
    var listaComponente = [['TELA','FORRO','ENTRETELA'],['TELA','FORRO','ENTRETELA']];
    var listaTejido = [['PUNTO','PLANO','PLANO - PUNTO'],['PUNTO','PLANO','PLANO - PUNTO']];

    componente = new Atributos('componente','contenedor_componente','componente_');

    componente.altura = '30px;';
    componente.campoid = 'idFichaTecnicaComponente';
    componente.campoEliminacion = 'eliminarComponente';

    componente.campos   = ['idFichaTecnicaComponente', 
                    'componenteFichaTecnicaComponente',
                    'tejidoFichaTecnicaComponente',
                    'composicionFichaTecnicaComponente'];

    componente.etiqueta = ['input','select', 'select','input'];
    componente.tipo     = ['hidden','','','text'];
    componente.estilo   = ['','width:400px;','width:400px;','width:400px;display: inline-block;'];
    componente.clase    = ['','chosen-select col-md-3','chosen-select col-md-3','col-md-4'];      
    componente.sololectura = [false,false,false,false];
    componente.opciones = ['',listaComponente,listaTejido,''];
    
    
    for(var j=0, k = fichacomponente.length; j < k; j++)
    {
        componente.agregarCampos(JSON.stringify(fichacomponente[j]),'L');
    }

    cargarTallas();
});


function cargarTallas() 
{
    
    talla.borrarTodosCampos();
    var id = document.getElementById('GrupoTalla_idGrupoTalla').value;
    if(id == '')
        return;

    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/consultarGrupoTalla',
        data:{idGrupoTalla: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
            

            // adicionamos los registros de tallas en un array para crear la lista de seleccion
            ids = Array();
            nombres = Array();
            for (var i = 0;  i <  data.length; i++) 
            {
                ids.push(data[i]["idTalla"]);
                nombres.push(data[i]["nombre1Talla"]);
            }
            maestrotalla = [ids, nombres];
            talla.opciones[1] = maestrotalla;
            
            // adicionamos los registros de tallas de la linea de produccion a la Ficha Tecnica
            for (var i = 0;  i < data.length; i++) 
            {
                valores = Array(0, data[i]["idTalla"], data[i]["tallaBaseGrupoTallaDetalle"], data[i]["curvaTallasGrupoTallaDetalle"]);
                talla.agregarCampos(valores,'A');
            }

            // en la pestaña de tabla de medidas, ponemos los titulos de la multiregistro, incluidas las tallas dinámicamente
            if(data.length == 0)
            {
                var titulosMedida = '<div id="" class="alert alert-danger alert-dismissible" role="alert">'+
                                        'La Línea de Producto seleccionada no tiene configuradas las tallas, debe asociarlas por el maestro de Líneas de Producto'+
                                    '</div> ';
            }
            else
            {
                var titulosMedida = 
                    '<div class="col-md-1" style="width: 40px;height: 42px; cursor:pointer;" onclick="medida.agregarCampos(valorMedida, \'A\');">'+
                    '   <span class="glyphicon glyphicon-plus"></span>'+
                    '</div>'+
                    '<div class="col-md-1" style="width: 200px;" >Medida</div>'+
                    '<div class="col-md-1" style="width: 200px;" >Observacion</div>'+
                    '<div class="col-md-1" style="width: 100px;" >Tolerancia</div>'+
                    '<div class="col-md-1" style="width: 100px;" >Escala</div>';

                for (var i = 0;  i <  data.length; i++) 
                {
                    var titulosMedida = titulosMedida + '<div class="col-md-1" style="width: 100px;text-align:center;'+(data[i]["tallaBaseGrupoTallaDetalle"] == 1 ? 'color:red;':'')+'" >'+data[i]["nombre1Talla"]+'</div>';
                }
            }
            $("#titulos").html(titulosMedida);


            // ahora creamos el prototipo para la multiregistro de Medidas, tamabien con las tallas dinamicas
            var valorMedida = ['','','',0,0];
            medida = new Atributos('medida','contenedor_medida','medida_');

            medida.altura = '30px;';
            medida.campoid = 'idFichaTecnicaMedida';
            medida.campoEliminacion = 'eliminarMedida';

            medida.campos   = ['idFichaTecnicaMedida', 
                            'ParteMedida_idParteMedida',
                            'observacionFichaTecnicaMedida',
                            'toleranciaFichaTecnicaMedida',
                            'escalaFichaTecnicaMedida'];

            medida.etiqueta = ['input','select', 'input','input', 'input'];
            medida.tipo     = ['hidden','','text','number','number'];
            medida.estilo   = ['','width:200px;','width:200px;display: inline-block;','width:100px;display: inline-block;text-align:center;','width:100px;display: inline-block;text-align:center;'];
            medida.clase    = ['','chosen-select','','',''];      
            medida.sololectura = [false,false,false,false, false];
            medida.opciones = ['',maestromedida,'','',''];

            for (var i = 0;  i <  data.length; i++) 
            {
                valorMedida.push(0,'');
                medida.campos.push('idFichaTecnicaMedidaTalla_'+data[i]["idTalla"],'Talla_'+data[i]["idTalla"]);
                medida.etiqueta.push('input','input');
                medida.tipo.push('hidden','text');
                medida.estilo.push('', 'width:100px;display: inline-block; text-align:center;'+(data[i]["tallaBaseGrupoTallaDetalle"] == 1 ? 'background-color:#D8F6CE; font-weight:bold;':''));
                

                medida.clase.push('','');
                medida.sololectura.push(false, false);
                medida.opciones.push('','');
            }

            // hacemos un rompimiento de control a la consulta de medidas, por parteMedida para obtener los valores de cada talla
            var reg = 0;
            var lin = 0;
            var tablaMedidas = new Array();
            while(reg < fichamedida.length)
            {
                var ParteAnt = fichamedida[reg]["ParteMedida_idParteMedida"];

                var temporal = new Array();
                temporal.push(fichamedida[reg]["idFichaTecnicaMedida"]); 
                temporal.push(fichamedida[reg]["ParteMedida_idParteMedida"]);
                temporal.push(fichamedida[reg]["observacionFichaTecnicaMedida"]);
                temporal.push(fichamedida[reg]["toleranciaFichaTecnicaMedida"]);
                temporal.push(fichamedida[reg]["escalaFichaTecnicaMedida"]);

                while(reg < fichamedida.length && ParteAnt == fichamedida[reg]["ParteMedida_idParteMedida"])
                {   
                    temporal.push(fichamedida[reg]["idFichaTecnicaMedidaTalla"]);
                    temporal.push(fichamedida[reg]["valorFichaTecnicaMedidaTalla"]);
                    reg++;
                }
                lin++;
                tablaMedidas.push(temporal);
            }

            for(var j=0, k = tablaMedidas.length; j < k; j++)
            {
                medida.agregarCampos(tablaMedidas[j],'A');
            }

            

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: '+err);
        }
    });
}

function calcularMedidas()
{
    
}

function guardarFichaTecnica()
{
    var formId = '#fichatec';
    var token = document.getElementById('token').value;
    
    $.ajax(
    {
        async: true,
        headers: {'X-CSRF-TOKEN': token},
        url: $(formId).attr('action'),
        type: $(formId).attr('method'),
        data: $(formId).serialize(),
        dataType: 'html',
        success: function(result)
        {
            alert('La ficha técnica se ha guardado correctamente');
            window.parent.$("#modalFichaTecnica").modal("hide");
            location.reload();
            //$(formId)[0].reset();            
        },
        error: function(result)
        {
            alert('No se ha podido guardar la ficha tecnica.');
        }
    });

}