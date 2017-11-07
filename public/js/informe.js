function limpiarMultiregistros()
{
    columnas.borrarTodosCampos();
    grupos.borrarTodosCampos();
    filtros.borrarTodosCampos();
}

function llamarVistas(id, valor) 
{
    // columnas.borrarTodosCampos();
    // grupos.borrarTodosCampos();
    // filtros.borrarTodosCampos();

    var select = document.getElementById('SistemaInformacion_idSistemaInformacion').value;
    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/llamarVistas',
        data:{idSistemaInformacion: id},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {

            $('#vistaInforme').html('');
            var select = document.getElementById('vistaInforme');

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione';
            select.appendChild(option);
            for (var i = 0;  i < data.length; i++) 
            {
                option = document.createElement('option');
                option.value = data[i]['TABLE_NAME'];
                option.text = (data[i]['TABLE_COMMENT'] != '' ? data[i]['TABLE_COMMENT'] : data[i]['TABLE_NAME']);

                option.selected = (valor == data[i]['TABLE_NAME'] ? true : false);

                select.appendChild(option);
            }
            $("#vistaInforme").trigger("chosen:updated");

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: ' +err);
        }
    });
}


function llamarCampos(tabla) 
{
    // columnas.borrarTodosCampos();
    // grupos.borrarTodosCampos();
    // filtros.borrarTodosCampos();
    
    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'/llamarCampos',
        data:{tabla: tabla},
        type:  'get',
        beforeSend: function(){},
        success: function(data)
        {
           
            var valores = new Array();
            var nombres = new Array();

            
            for(var j=0; j < data.length; j++)
            {
                valores[j] = data[j].COLUMN_NAME;
                nombres[j] = data[j].COLUMN_COMMENT;
            }
            //console.log(valores);
            // con el array de campos, cambiamos el valor de las opciones para la multiregistro de condiciones que 
            // muestra los mismos nombres de campo
            filtros.opciones[2] = [valores,nombres];
            

        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: ' +err);
        }
    });
}


function abrirModalCampos(idiframe, ruta)
{
    var $iframe = $('#' + idiframe);
    if ( $iframe.length ) {
        $iframe.attr('src',ruta);   
        $('#ModalCampos').modal('show');
    }
}


function adicionarRegistros(nombreTabla, datos)
{

    switch(nombreTabla)  
    {
        case 'tinformecampo':

           for (var i = 0; i < datos.length; i++) 
            {
                formato = ((datos[i][2] == 'varchar' || datos[i][2] == 'text') 
                            ? 'Texto' 
                            : ((datos[i][2] == 'int' || datos[i][2] == 'decimal') 
                            ? 'NumeroSeparador' 
                            : ((datos[i][2] == 'date' || datos[i][2] == 'datetime') 
                            ? 'AMD' 
                            : ''))); 
                var valores = new Array(0, ((i+1)*5), datos[i][1], 0,0,0, datos[i][0],  'I','S','','I', '',formato,datos[i][3], datos[i][4]);

                window.parent.columnas.agregarCampos(valores,'A');  
            }
            $('#ModalCampos').modal('hide');
        break;

    }
}


function modificarGrupo(nombre)
{   
    
    reg = nombre.replace('grupoInformeColumnaC', '');
    
    if($("#grupoInformeColumna"+reg).val() == '0')
    {
        valores = new Array(0, $("#campoInformeColumna"+reg).val(), $("#tituloInformeColumna"+reg).val()+':  ', 'Totales '+$("#tituloInformeColumna"+reg).val()+':  ', 1 );
        grupos.agregarCampos(valores, 'A');
    }
    else
    {
        // si el check queda apagado, debemos buscar y eliminar el registro del grupo
        for(i = 0; i < grupos.contador; i++)
        {
            if($("#campoInformeGrupo"+i) && $("#campoInformeGrupo"+i).val() == $("#campoInformeColumna"+reg).val())
            {
                grupos.borrarCampos('informegrupo'+i,'eliminarInformeGrupo','idInformeGrupo'+i);
            }
        }
    }
}


function validarFormulario(event)
{
    
    var route = "http://"+location.host+"/informe";
    var formId = 'frmInforme';
    var token = $("#token").val();

    var dato = document.getElementById('idInforme').value;
    var dato0 = document.getElementById('nombreInforme').value;
    var dato1 = document.getElementById('CategoriaInforme_idCategoriaInforme').value;
    var dato2 = document.getElementById('SistemaInformacion_idSistemaInformacion').value;
    var dato3 = document.getElementById('vistaInforme').value;

    var datoCampo = document.querySelectorAll("[name='campoInformeColumna[]']");
    var datoTitulo = document.querySelectorAll("[name='tituloInformeColumna[]']");
    var datoAliH = document.querySelectorAll("[name='alineacionHInformeColumna[]']");
    var datoAliV = document.querySelectorAll("[name='alineacionVInformeColumna[]']");
    var datoFormato = document.querySelectorAll("[name='formatoInformeColumna[]']");
    
    var dato4 = [];
    var dato5 = [];
    var dato6 = [];
    var dato7 = [];
    var dato8 = [];
  
    var valor = '';
    var sw = true;
    
    for(var j=0,i=datoCampo.length; j<i;j++)
    {
        dato4[j] = datoCampo[j].value;
    }
    for(var j=0,i=datoTitulo.length; j<i;j++)
    {
        dato5[j] = datoTitulo[j].value;
    }
    for(var j=0,i=datoAliH.length; j<i;j++)
    {
        dato6[j] = datoAliH[j].value;
    }
    for(var j=0,i=datoAliV.length; j<i;j++)
    {
        dato7[j] = datoAliV[j].value;
    }
    for(var j=0,i=datoFormato.length; j<i;j++)
    {
        dato8[j] = datoFormato[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: { respuesta: 'falso',
                idInforme : dato,
                nombreInforme: dato0,
                CategoriaInforme_idCategoriaInforme: dato1,
                SistemaInformacion_idSistemaInformacion: dato2,
                vistaInforme: dato3,
                campoInformeColumna: dato4,
                tituloInformeColumna: dato5,
                alineacionHInformeColumna: dato6,
                alineacionVInformeColumna: dato7,
                formatoInformeColumna: dato8
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


function mostrarModalRol()
{

   $('#ModalRoles').modal('show'); 
    
}

function mostrarModalCompania()
{

   $('#ModalCompanias').modal('show'); 
    
}

function cargarFiltros(idInforme)
{
    alert(idInforme);
    var token = document.getElementById('token').value;
    $.ajax(
    {
        headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        url:'http://'+location.host+'/llamarFiltros', /*Funcion para ejecutar  el Ajax para que consulte en la BD la tabla de sublineas */
        data:{idInforme: idInforme}, // Este id lo envia por get para el ajax
        type:  'get',   
        beforeSend: function(){},
        success: function(data)
        {
            console.log(data);
            //con el nombre de l atabla del informe, cargamos los campos
            llamarCampos(data[0]["vistaInforme"]);
            //    console.log(filtros.opciones);
            //Recorre los registros de sublineas para irlos  creando como opciones en esa lista
            for (var i = 0;  i < data.length; i++) 
            {
                var valorfiltros = [data[i]['idInformeFiltro'], 
                                    data[i]['agrupadorInicialInformeFiltro'], 
                                    data[i]['campoInformeFiltro'], 
                                    data[i]['operadorInformeFiltro'], 
                                    data[i]['valorInformeFiltro'], 
                                    data[i]['agrupadorFinalInformeFiltro'], 
                                    data[i]['conectorInformeFiltro'] ];
                //filtros.agregarCampos(valorfiltros, 'A');
            }
        },
        error:    function(xhr,err)
        {
            alert('Se ha producido un error: ' +err);
        }
    });
}


function concatenarCondicion()
{
    datos = '';
    for(i = 0; i < filtros.contador; i++)
    {
        if($("#operadorInformeFiltro"+i))
        {
            // todos los operadores estan tal cual se requieren para SQL, excepto
            // el like y el BETWEEN que son especiales en su sintaxis
            // "=", ">", ">=", "<", "<=", "!=", "%like", "like%", "%like%", "BETWEEN"
            operadorBase = $("#operadorInformeFiltro"+i).val().replace(/%/g,'');

            switch(operadorBase)
            {
                case 'like':
                    // al operador le quitamos los %
                    operador = operadorBase;
                    // al valor lo ubicamos odnde esta la palabra like para que le queden los % en elorden correcto
                    valor = $("#operadorInformeFiltro"+i).val().replace('like',$("#valorInformeFiltro"+i).val());
                    break;

                case 'BETWEEN':
                    // para el between, el usuario debe escribir los 2 valores separados por coma y
                    // aca convertremos la coma por un AND
                    // el operador no cambia
                    operador = $("#operadorInformeFiltro"+i).val();
                    // al valor lo separamos con AND (donde esta la coma)
                    valor = $("#valorInformeFiltro"+i).val().replace(',','" AND "');
                    break;

                default:
                    operador = $("#operadorInformeFiltro"+i).val();
                    valor = $("#valorInformeFiltro"+i).val();
                    break;
            } 

            datos += 
                $("#agrupadorInicialInformeFiltro"+i).val()+' '+
                $("#campoInformeFiltro"+i).val()+' '+
                operador+' '+
                '"'+valor+'" '+
                $("#agrupadorFinalInformeFiltro"+i).val()+' '+
                $("#conectorInformeFiltro"+i).val()+' ';
        }
    }
    condicion = datos.substring(1, datos.length - 4);
    idInforme = $("#idInforme").val()
    window.open('generarinforme/'+ idInforme+'/'+condicion,'informe'+idInforme,'width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
}
