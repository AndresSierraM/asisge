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

// function llenarObjetivo(idObjetivo)
// {
//          var token = document.getElementById('token').value;

//             $.ajax({
//                 headers: {'X-CSRF-TOKEN': token},
//                 dataType: "json",
//                 data: {'CompaniaObjetivo_idCompaniaObjetivo': idObjetivo},
//                 url:   'http://localhost:8000/llenarObjetivo/',
//                 type:  'post',
//                 beforeSend: function(){
//                     //Lo que se hace antes de enviar el formulario
//                     },
//                 success: function(respuesta){
                    
//                     $("#objetivoCalidad").val(respuesta);
//                 },
//                 error:    function(xhr,err){ 
//                     alert("Error");
//                 }
//             });
// }

    function divFormula()
    {
        document.getElementById("formula").style.display = "block";
    }

    function mostrarDiv(div)
    {
        document.getElementById("indicador").style.display = "none";
        document.getElementById("valorConstante").style.display = "none";
        document.getElementById("variable").style.display = "none";

        document.getElementById(div).style.display = "block";
    }

    function mostrarDivCA(divCA)
    {
        document.getElementById("condicion").style.display = "none";
        document.getElementById("agrupador").style.display = "none";

        document.getElementById(divCA).style.display = "block";
    }

    function concatenarFormula(dato)
    {
        document.getElementById('formulaconcatenada').value = document.getElementById('formulaconcatenada').value + dato;
    }

    function borrarTodo()
    {
        document.getElementById('formulaconcatenada').value = document.getElementById('formulaconcatenada').value = '';
    }

    function consultarCampos(idModulo){

    var token = document.getElementById('token').value;

    $.ajax({
            async: true,
            headers: {'X-CSRF-TOKEN': token},
            url: 'http://localhost:8000/consultarCampos',
            method: 'POST',
            data: {Modulo_idModulo: idModulo},


            success: function(data){

                var valoresd = data[0];      
                var select = document.getElementById('campoCuadroMandoFormula');
                var arr = [];
for (var prop in valoresd) {
    arr.push(valoresd[prop]);
}
console.log(arr);
                select.options.length = 0;
                var option = '';

                option = document.createElement('option');
                option.value = '';
                option.text = 'Seleccione el campo';
                select.appendChild(option);
                // alert(valoresd.length);
                for(var j=0,k=valoresd.length;j<k;j++)
                {
                    option = document.createElement('option');
                    // option.value = valoresd[j][0];
                    // option.text = valoresd[j][4];

                    option.value = valoresd[j].COLUMN_NAME;
                    option.text = valoresd[j].COLUMN_COMMENT;
                    select.appendChild(option);
                }
            }
        });
}

   