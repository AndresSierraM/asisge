// var Atributos = function(nombreObjeto, nombreContenedor, nombreDiv){

//     this.nombre = nombreObjeto;
//     this.contenedor = nombreContenedor;
//     this.contenido = nombreDiv;
//     this.contador = 0;
//     this.campos = new Array();
//     this.etiqueta = new Array();
//     this.tipo = new Array();
//     this.estilo = new Array();
//     this.clase = new Array();
//     this.sololectura = new Array();
//     this.etiqueta = new Array();
    
//     this.nombreCompaniaObjetivo = new Array();
//     this.valorCompaniaObjetivo = new Array();

//     this.nombreProceso = new Array();
//     this.valorProceso = new Array();

//     this.nombretipoMeta = new Array('C','%','$');

//     this.nombreoperadorMeta = new Array('>','>=','<','<=','=');
    

//     this.nombreFrecuenciaMedicion = new Array();
//     this.valorFrecuenciaMedicion = new Array();

//     this.nombreTercero = new Array();
//     this.valorTercero = new Array();


//     this.eventoclick = new Array();

// };

// Atributos.prototype.agregarCampos = function(datos, tipo){

//     var valor;
//     if(tipo == 'A')
//        valor = datos;
//     else
//         valor = $.parseJSON(datos);
//     var espacio = document.getElementById(this.contenedor);
//     var caneca = document.createElement('div');
//     var img = document.createElement('i');
//     var div = document.createElement('div');
//     div.id = this.contenido+this.contador;
//     div.setAttribute("width", '100%');

//     for (var i = 0,  e = this.campos.length; i < e ; i++)
//     {

//         if(this.etiqueta[i] == 'input')
//         {
//             var input = document.createElement('input');
//             input.type =  this.tipo[i];
//             input.id =  this.campos[i] + this.contador;
//             input.name =  this.campos[i]+'[]';

//             input.value = valor[(tipo == 'A' ? i : this.campos[i])];
//             input.setAttribute("class", this.clase[i]);
//             input.setAttribute("style", this.estilo[i]);

//             div.appendChild(input);
//         }
//         else if(this.etiqueta[i] == 'textarea')
//         {
//             var input = document.createElement('textarea');
//             input.id =  this.campos[i] + this.contador;
//             input.name =  this.campos[i]+'[]';

//             input.value = valor[(tipo == 'A' ? i : this.campos[i])];
//             input.setAttribute("class", this.clase[i]);
//             input.setAttribute("style", this.estilo[i]);

//             div.appendChild(input);
//         }
//         else if(this.etiqueta[i] == 'select')
//         {

//             var select = document.createElement('select');
//             var option = '';
//             select.id =  this.campos[i] + this.contador;
//             select.name =  this.campos[i]+'[]';
//             select.setAttribute("style", this.estilo[i]);
//             select.setAttribute("class", this.clase[i]);
            
//             // para construir las diferentes listas de seleccion, consultamos  los nombres de los 
//             // campos que van en cada uno de los select

//             switch(detalle.campos[i])
//             {
//                 case 'CompaniaObjetivo_idCompaniaObjetivo':
//                     for(var j=0,k=this.valorCompaniaObjetivo.length;j<k;j++)
//                     {
//                         option = document.createElement('option');
//                         option.value = this.valorCompaniaObjetivo[j];
//                         option.text = this.nombreCompaniaObjetivo[j];
//                         option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.valorCompaniaObjetivo[j] ? true : false);
//                         select.appendChild(option);
//                     }
//                     break 
//                 case'Proceso_idProceso':  
//                     for(var j=0,k=this.valorProceso.length;j<k;j++)
//                     {
//                         option = document.createElement('option');
//                         option.value = this.valorProceso[j];
//                         option.text = this.nombreProceso[j];
//                         option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.valorProceso[j] ? true : false);
//                         select.appendChild(option);
//                     }
//                     break 
//                case'operadorMetaCuadroMandoDetalle':
//                     for(var j=0,k=this.nombreoperadorMeta.length;j<k;j++)
//                     {
//                         option = document.createElement('option');
//                         option.value = this.nombreoperadorMeta[j];
//                         option.text = this.nombreoperadorMeta[j];
//                         option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.nombreoperadorMeta[j] ? true : false);
//                         select.appendChild(option);
//                     }
//                     break 
//                 case'tipoMetaCuadroMandoDetalle':
//                     for(var j=0,k=this.nombretipoMeta.length;j<k;j++)
//                     {
//                         option = document.createElement('option');
//                         option.value = this.nombretipoMeta[j];
//                         option.text = this.nombretipoMeta[j];
//                         option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.nombretipoMeta[j] ? true : false);
//                         select.appendChild(option);
//                     }
//                     break 
//                 case'FrecuenciaMedicion_idFrecuenciaMedicion':
//                     for(var j=0,k=this.valorProceso.length;j<k;j++)
//                     {
//                         option = document.createElement('option');
//                         option.value = this.valorFrecuenciaMedicion[j];
//                         option.text = this.nombreFrecuenciaMedicion[j];
//                         option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.valorFrecuenciaMedicion[j] ? true : false);
//                         select.appendChild(option);
//                     }
//                     break 
//                 case'Tercero_idResponsable':
//                     for(var j=0,k=this.valorTercero.length;j<k;j++)
//                     {
//                         option = document.createElement('option');
//                         option.value = this.valorTercero[j];
//                         option.text = this.nombreTercero[j];
//                         option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.valorTercero[j] ? true : false);
//                         select.appendChild(option);
//                     }
//                     break 
//             }

//             div.appendChild(select);

 
//         }
//         else if(this.etiqueta[i] == 'checkbox')
//         {
//             var divCheck = document.createElement('div');
//             divCheck.setAttribute('class',this.clase[i]);
//             divCheck.setAttribute('style',this.estilo[i]);
 
//             var inputHidden = document.createElement('input');
//             inputHidden.type =  'hidden';
//             inputHidden.id =  this.campos[i] + this.contador;
//             inputHidden.name =  this.campos[i]+'[]';
//             inputHidden.value = valor[i];
 
//             divCheck.appendChild(inputHidden);
 
//             var input = document.createElement('input');
//             input.type = this.tipo[i];
//             input.setAttribute('style',this.estilo[i]);
//             input.id =  this.campos[i]+'C'+this.contador;
//             input.name =  this.campos[i]+'C'+'[]';
//             input.checked = (valor[(tipo == 'A' ? i : this.campos[i])] == 1 ? true : false);
//             input.setAttribute("onclick", this.nombre+'.cambiarCheckbox("'+this.campos[i]+'",'+this.contador+')');
     
//             divCheck.appendChild(input);
 
//             div.appendChild(divCheck);
//         }

//     }

//     caneca.id = 'eliminarRegistro'+ this.contador;
//     caneca.setAttribute('onclick',this.nombre+'.borrarCampos('+this.contenido+this.contador+')');
//     caneca.setAttribute("class","col-md-1");
//     caneca.setAttribute("style","width:40px; height: 34px;");
//     img.setAttribute("class","glyphicon glyphicon-trash");

//     caneca.appendChild(img);
//     div.appendChild(caneca);
//     espacio.appendChild(div);

//     this.contador++;

//     var config = {
//       '.chosen-select'           : {},
//       '.chosen-select-deselect'  : {allow_single_deselect:true},
//       '.chosen-select-no-single' : {disable_search_threshold:10},
//       '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
//       '.chosen-select-width'     : {width:"95%"}
//     }
//     for (var selector in config) {
//       $(selector).chosen(config[selector]);
//     }
// }

// Atributos.prototype.borrarCampos = function(elemento){

//     aux = elemento.parentNode;
//     aux.removeChild(elemento);

// }

// Atributos.prototype.cambiarCheckbox = function(campo, registro)
// {
//     //console.log(campo+' ----> '+registro);
//     document.getElementById(campo+registro).value = document.getElementById(campo+"C"+registro).checked ? 1 : 0;
// }

function llenarObjetivo(idObjetivo)
{
         var token = document.getElementById('token').value;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                dataType: "json",
                data: {'CompaniaObjetivo_idCompaniaObjetivo': idObjetivo},
                url:   'http://localhost:8000/llenarObjetivo/',
                type:  'post',
                beforeSend: function(){
                    //Lo que se hace antes de enviar el formulario
                    },
                success: function(respuesta){
                    
                    $("#objetivoCalidad").val(respuesta);
                },
                error:    function(xhr,err){ 
                    alert("Error");
                }
            });
}

    function divFormula()
    {
        document.getElementById("formula").style.display = "block";
    }

    function mostrarDiv(div)
    {
        document.getElementById("formIndicador").style.display = "none";
        document.getElementById("formConstante").style.display = "none";
        document.getElementById("formVariable").style.display = "none";

        if(div != '')
            document.getElementById(div).style.display = "block";

    }

    function mostrarDivCA(divCA)
    {
        document.getElementById("condicion").style.display = "none";
        document.getElementById("agrupador").style.display = "none";

        if(divCA != '')
        {
            document.getElementById(divCA).style.display = "block";
        }
    }

    function concatenarFormula(dato, boton)
    {
        // incrementamos el contador de componentes de la formula antes de crearlo
        document.getElementById("contadorFormula").value++;

        // adicionamos a la formula el nombre del indicador/constante/variable
        document.getElementById('formulaconcatenada').value = document.getElementById('formulaconcatenada').value + boton;

        
        document.getElementById("contenedorFormula").innerHTML += '<div id="'+document.getElementById("contadorFormula").value+'" class="btn btn-default">'+boton+'</div>';
         

        document.getElementById("datosGrabarFormula").value += dato;         

        // Ocultamos el div indicador/constante/variable
        mostrarDiv('');

    }


    function concatenarDatos(div, dato)
    {
         // con el fin de hacer el grabado de las tablas de detalle de la formula, vamos concatenando los datos en un input
        // que luego viajara a traves de POST al controlador, donde lo separamos y procesamos para grabarlo en las tablas
        // esta estructura de datos contine los datos en el mismo orden que estan los campos de la tabla a grabar
        // Tabla: cuadromandoformula 
        // Campos:
        //      idCuadroMandoFormula, CuadroMando_idCuadroMando, tipoCuadroMandoFormula, CuadroMando_idIndicador, 
        //      nombreCuadroMandoFormula, Modulo_idModulo, campoCuadroMandoFormula, calculoCuadroMandoFormula
        var idCuadroMandoFormula = 0;
        var CuadroMando_idCuadroMando = 0;
        var tipoCuadroMandoFormula = '';
        var CuadroMando_idIndicador = 0;
        var nombreCuadroMandoFormula =  '';
        var Modulo_idModulo = 0;
        var campoCuadroMandoFormula = '';
        var calculoCuadroMandoFormula = '';

        componente =  parseFloat(document.getElementById("contadorFormula").value)+1;
        var datos = '';
        switch(div)
        {
            case 'formVariable':
                idCuadroMandoFormula = componente;
                CuadroMando_idCuadroMando = 0;
                tipoCuadroMandoFormula = 'Variable';
                CuadroMando_idIndicador = 0;
                nombreCuadroMandoFormula = document.getElementById('nombreVariable').value;
                Modulo_idModulo = document.getElementById('Modulo_idModulo').value;
                campoCuadroMandoFormula = document.getElementById('campoCuadroMandoFormula').value;
                calculoCuadroMandoFormula = document.getElementById('calculoCuadroMandoFormula').value;

                // limpiamos los campos
                document.getElementById('nombreVariable').value = '';
                document.getElementById('Modulo_idModulo').value = '';
                document.getElementById('campoCuadroMandoFormula').value = '';
                document.getElementById('calculoCuadroMandoFormula').value = '';
                
            break;

            case 'formIndicador':
                idCuadroMandoFormula = componente;
                CuadroMando_idCuadroMando = 0;
                tipoCuadroMandoFormula = 'Indicador';
                CuadroMando_idIndicador = document.getElementById('Indicador').value;
                nombreCuadroMandoFormula = document.getElementById('Indicador').options[document.getElementById('Indicador').selectedIndex].text;
                Modulo_idModulo = 0;
                campoCuadroMandoFormula = '';
                calculoCuadroMandoFormula = '';

                // limpiamos los campos
                document.getElementById('Indicador').value = '';
            break;

            case 'formConstante':
                idCuadroMandoFormula = componente;
                CuadroMando_idCuadroMando = 0;
                tipoCuadroMandoFormula = 'Constante';
                CuadroMando_idIndicador = 0;
                nombreCuadroMandoFormula =  document.getElementById('valorConstante').value;
                Modulo_idModulo = 0;
                campoCuadroMandoFormula = '';
                calculoCuadroMandoFormula = '';

                 // limpiamos los campos
                document.getElementById('valorConstante').value = '';
            break;

            case 'Operador':
                idCuadroMandoFormula = componente;
                CuadroMando_idCuadroMando = 0;
                tipoCuadroMandoFormula = 'Operador';
                CuadroMando_idIndicador = 0;
                nombreCuadroMandoFormula =  dato;
                Modulo_idModulo = 0;
                campoCuadroMandoFormula = '';
                calculoCuadroMandoFormula = '';

            break;
        }
        
        datos += idCuadroMandoFormula+','+CuadroMando_idCuadroMando+','+tipoCuadroMandoFormula+','+CuadroMando_idIndicador+','+nombreCuadroMandoFormula+','+Modulo_idModulo+','+campoCuadroMandoFormula+','+calculoCuadroMandoFormula+'|';

        concatenarFormula(datos, nombreCuadroMandoFormula);
    }

    function concatenarCondicion()
    {
        datos = '';
        componente =  parseFloat(document.getElementById("contadorFormula").value)+1;

        for(i = 0; i < cuadromandocondicion.contador; i++)
        {
            datos += 
                componente+','+
                document.getElementById("parentesisInicioCuadroMandoCondicion"+i).value+','+
                document.getElementById("campoCuadroMandoCondicion"+i).value+','+
                document.getElementById("operadorCuadroMandoCondicion"+i).value+','+
                document.getElementById("valorCuadroMandoCondicion"+i).value+','+
                document.getElementById("parentesisFinCuadroMandoCondicion"+i).value+','+
                document.getElementById("conectorCuadroMandoCondicion"+i).value+'|';
        }
        document.getElementById("datosGrabarCondicion").value += datos;

        // luego de salvar los datos en el campo concatenado, eliminamos los registros para una proxima condicion
        document.getElementById("contenedor_cuadromandocondicion").innerHTML = '';
        // reiniciamos el contador de registros de la condicion
        cuadromandocondicion.contador = 0;

        // ocultamos el div de condiciones
        mostrarDivCA('');
    }


    function concatenarAgrupador()
    {
        datos = '';
        componente =  parseFloat(document.getElementById("contadorFormula").value)+1;

        for(i = 0; i < cuadromandoagrupador.contador; i++)
        {
            datos += 
                componente+','+
                document.getElementById("campoCuadroMandoAgrupador"+i).value+'|';
        }
        document.getElementById("datosGrabarAgrupador").value += datos;

        // luego de salvar los datos en el campo concatenado, eliminamos los registros para una proxima condicion
        document.getElementById("contenedor_cuadromandoagrupador").innerHTML = '';
        // reiniciamos el contador de registros de la condicion
        cuadromandoagrupador.contador = 0;

        // ocultamos el div de condiciones
        mostrarDivCA('');
    }


    function borrarTodo()
    {
        // limpiamos la formula concatenada (string)
        document.getElementById('formulaconcatenada').value = '';
        
        // limpiamos la formula en forma de botones
        document.getElementById("contenedorFormula").innerHTML = '';

        // limpiamos los campos de datos a grabar (formula condicion y agrupacion)
        document.getElementById('datosGrabarFormula').value = '';
        document.getElementById('datosGrabarCondicion').value = '';
        document.getElementById('datosGrabarAgrupador').value = '';

    }


    function borrarUltimo(id)
    {
        // tomamos el nombre del componente antes de eliminarlo
        valor = document.getElementById(id).innerHTML;

        // eliminamos el ultimo componente (div) de la formula en forma de botones
        document.getElementById("contenedorFormula").removeChild(document.getElementById(id)); 
       
        
        // limpiamos de la formula concatenada el componente eliminado (string)
        // verificamos la longitud del componente para quitar esta parte del final de la formula

        formula = document.getElementById('formulaconcatenada').value;
        document.getElementById('formulaconcatenada').value = formula.substring(0, (formula.length - valor.length));

        // tomamos el contenido del campo datosGrabarFormula y lo pasamos a una variable auxiliar, 
        // luego recorremos el numero de veces del nodo que 
        // vamos a borrar menos uno, ejemplo: si el nodo a borrar es el 3, le vamos a quitar a la variable auxiliar
        // los 2 primeros datos para dejar solo el que necesitamos borrar
        // luego con ese sabremos que borrar desde el campo datosGrabarFormula
        auxiliar = document.getElementById('datosGrabarFormula').value;
        for (i = 0; i < id-1; i++)
        {
            // vamos quitando el primer dato
            auxiliar = auxiliar.substring(auxiliar.indexOf('|')+1);
        }
        // al final solo nos queda en la variable auxiliar el ultimo dato
        document.getElementById('datosGrabarFormula').value = document.getElementById('datosGrabarFormula').value.substring(0, (document.getElementById('datosGrabarFormula').value.length - auxiliar.length));

        // Eliminamos las condiciones correspondientes al id del componente
        // como puede tenenr varias condiciones asociadas al mismo numero de componente, si encontramos una, vamos salvando
        // las condiciones anteriores en otra variable, al final las que queden en la variable 2 son las que no podemos borrar
        // ejemplo de datos :   3,...............|3,...............|1,...............|2,...............|3,...............|
        var auxiliar = document.getElementById('datosGrabarCondicion').value;
        var auxiliar2 = '';
        var componElim = id+',';

        while(auxiliar != '')
        {
            // buscamos el PIPE (separador)
            registrocond = auxiliar.substring(0, auxiliar.indexOf('|')+1);

            // si ese registro comienza por el numero de componente antes de la primara coma, lo eliminamos del 
            // auxiliar sin salvarlo, por el contrario si no empieza por el componente, lo eliminamos pero despues 
            // de salvarlo en la auxiliar2
            if(registrocond.substring(0, componElim.length) != componElim)
            {
                auxiliar2 += registrocond; 
            }

            // vamos quitando el primer dato (desde el siguiente caractar del pipe hasta el final)
            auxiliar = auxiliar.substring(auxiliar.indexOf('|')+1);
        }

        // en este punto debemos tener la variable auxiliar 2 con los registros correctos 
        // alert(auxiliar2);
        // al final solo nos queda en la variable auxiliar el ultimo dato
        document.getElementById('datosGrabarCondicion').value = auxiliar2;




        // realizamos el mismo proceso para quitar los componentes del agrupador
        var auxiliar = document.getElementById('datosGrabarAgrupador').value;
        var auxiliar2 = '';
        var componElim = id+',';

        while(auxiliar != '')
        {
            // buscamos el PIPE (separador)
            registrocond = auxiliar.substring(0, auxiliar.indexOf('|')+1);

            // si ese registro comienza por el numero de componente antes de la primera coma, lo eliminamos del 
            // auxiliar sin salvarlo, por el contrario si no empieza por el componente, lo eliminamos pero despues 
            // de salvarlo en la auxiliar2
            if(registrocond.substring(0, componElim.length) != componElim)
            {
                auxiliar2 += registrocond; 
            }

            // vamos quitando el primer dato (desde el siguiente caractar del pipe hasta el final)
            auxiliar = auxiliar.substring(auxiliar.indexOf('|')+1);
        }

        // en este punto debemos tener la variable auxiliar 2 con los registros correctos 
        // al final solo nos queda en la variable auxiliar el ultimo dato
        document.getElementById('datosGrabarAgrupador').value = auxiliar2;


        // restamos 1 al contador de componentes de la formula
        document.getElementById('contadorFormula').value--;

    }



    function consultarCampos(idModulo)
    {

        var token = document.getElementById('token').value;

        $.ajax({
            async: true,
            headers: {'X-CSRF-TOKEN': token},
            url: 'http://localhost:8000/CuadroMandoConsultarCampos',
            method: 'POST',
            data: {idModulo: idModulo},


            success: function(data){
                
                // los datos recibidos en formato JSON desde el ajax son de tipo 
                // string, para trabajar con ellos debemos convertirlos a JSON
                var data = JSON.parse(data);
                
                var select = document.getElementById('campoCuadroMandoFormula');

                select.options.length = 0;
                var option = '';
                var valores = new Array();
                var nombres = new Array();

                option = document.createElement('option');
                option.value = '';
                option.text = 'Seleccione el campo';
                select.appendChild(option);
                
                for(var j=0; j < data.length; j++)
                {
                    option = document.createElement('option');

                    option.value = data[j].COLUMN_NAME;
                    option.text = data[j].COLUMN_COMMENT;
                    select.appendChild(option);

                    valores[j] = data[j].COLUMN_NAME;
                    nombres[j] = data[j].COLUMN_COMMENT;
                }

                // con el array de campos, cambiamos el valor de las opciones para la multiregistro de condiciones que 
                // muestra los mismos nombres de campo
                cuadromandocondicion.opciones[1] = [valores,nombres];
                // y los mismos campos para el multiregistro de agrupadores
                cuadromandoagrupador.opciones[0] = [valores,nombres];

            }
        });
    }


    function consultarCalculos(idModulo, Campo)
    {

        var token = document.getElementById('token').value;

        $.ajax({
            async: true,
            headers: {'X-CSRF-TOKEN': token},
            url: 'http://localhost:8000/CuadroMandoConsultarCalculos',
            method: 'POST',
            data: { idModulo: idModulo, 
                    nombreCampo: Campo},


            success: function(data){
                
                // los datos recibidos en formato JSON desde el ajax son de tipo 
                // string, para trabajar con ellos debemos convertirlos a JSON
                var data = JSON.parse(data);
                
                var select = document.getElementById('calculoCuadroMandoFormula');

                select.options.length = 0;
                var option = '';

                option = document.createElement('option');
                option.value = '';
                option.text = 'Ninguno';
                select.appendChild(option);
                
                var tipo = '';
                for(var j=0; j < data.length; j++)
                {
                    tipo = data[j].COLUMN_TYPE.substring(0,3);
                    
                    option = document.createElement('option');
                    option.value = 'Conteo';
                    option.text = 'Conteo';
                    select.appendChild(option);

                    if(tipo == 'int' || tipo == 'dec' || tipo == 'flo')
                    {
                        option = document.createElement('option');
                        option.value = 'Suma';
                        option.text = 'Sumatoria';
                        select.appendChild(option);

                        option = document.createElement('option');
                        option.value = 'Promedio';
                        option.text = 'Promedio';
                        select.appendChild(option);

                        option = document.createElement('option');
                        option.value = 'Minimo';
                        option.text = 'Minimo';
                        select.appendChild(option);

                        option = document.createElement('option');
                        option.value = 'Maximo';
                        option.text = 'Maximo';
                        select.appendChild(option);
                    }
                    else if(tipo == 'dat')
                    {
                        option = document.createElement('option');
                        option.value = 'Minimo';
                        option.text = 'Minimo';
                        select.appendChild(option);

                        option = document.createElement('option');
                        option.value = 'Maximo';
                        option.text = 'Maximo';
                        select.appendChild(option);
                    }
                }
            }
        });
    }
   