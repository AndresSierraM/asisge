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
//     this.nombreCompletoTercero = new Array();
//     this.idTercero = new Array();
//     this.nombreDocumento = new Array();
//     this.idDocumento = new Array();
//     this.eventoclick = new Array();
//     this.funciones = new Array();

// };

// Atributos.prototype.agregarCampos = function(datos, tipo, idTercero, idDocumento){

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
            
//              if(typeof(this.funciones[i]) !== "undefined") 
//             {
//                 for(var h=0,c = this.funciones[i].length;h<c;h+=2) 
//                 {
//                     input.setAttribute(this.funciones[i][h], this.funciones[i][h+1]);
//                 }
//             }


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
//         else if(this.etiqueta[i] == 'select1')
//         {

//             var select = document.createElement('select');
//             var option = '';
//             select.id =  this.campos[i] + this.contador;
//             select.name =  this.campos[i]+'[]';
//             select.setAttribute("style", this.estilo[i]);
//             select.setAttribute("class", this.clase[i]);
            
             
//             for(var j=0,k=this.idTercero.length;j<k;j++)
//             {
//                 option = document.createElement('option');
//                 option.value = this.idTercero[j];
//                 option.text = this.nombreCompletoTercero[j];

//                 option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.idTercero[j] ? true : false);
//                 select.appendChild(option);
//             }
 
//             div.appendChild(select);

 
//         }
//         else if(this.etiqueta[i] == 'select2')
//         {

//             var select = document.createElement('select');
//             var option = '';
//             select.id =  this.campos[i] + this.contador;
//             select.name =  this.campos[i]+'[]';
//             select.setAttribute("style", this.estilo[i]);
//             select.setAttribute("class", this.clase[i]);
            
             
//             for(var j=0,k=this.idDocumento.length;j<k;j++)
//             {
//                 option = document.createElement('option');
//                 option.value = this.idDocumento[j];
//                 option.text = this.nombreDocumento[j];

//                 option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.idDocumento[j] ? true : false);
//                 select.appendChild(option);
//             }
 
//             div.appendChild(select);

 
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

function habilitarSubmit(event)
{
    event.preventDefault();
    

    validarformulario();
}

function validarformulario()
{

    var resp = true;

        // Se hace un if para validar por medio del ID si el campo esta vacio para que este se pinte de Rojo 
        // de lo contrario se quedara en blanco y dejara guardar.
        // SI esta vacio este devolvera el campo de color rojo y detendra el formulario 
        if((document.getElementById("Proceso_idProceso").value == '' ))
            {
                // document.getElementById("TipoInspeccion_idTipoInspeccion").style = "background-color:#F5A9A9;";
                //se deja en false para que no envie el formulario hasta que elijan una opcion del select
                resp = false;
            } 
            else
                {
                      // document.getElementById("TipoInspeccion_idTipoInspeccion").style = "background-color:white;";  
                      resp = true;
                } 
         if((document.getElementById("nombreProcedimiento").value == '' ))
            {
                document.getElementById("nombreProcedimiento").style = "background-color:#F5A9A9;";
                resp = false;
            } 
            else
                {
                     document.getElementById("nombreProcedimiento").style = "background-color:white;";
                } 
         if((document.getElementById("fechaElaboracionProcedimiento").value == '' ))
            {
                document.getElementById("fechaElaboracionProcedimiento").style = "background-color:#F5A9A9;";
                resp = false;
            } 
            else
                {
                     document.getElementById("fechaElaboracionProcedimiento").style = "background-color:white;";
                } 
    // Validamos los datos de detalle
    for(actual = 0; actual < procedimiento.contador ; actual++)
    {
        if((document.getElementById("actividadProcedimientoDetalle"+(actual)).value == null))
        {
            document.getElementById("actividadProcedimientoDetalle"+(actual)).style = "width: 500px; height: 35px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("actividadProcedimientoDetalle"+(actual)).style = "width: 500px; height: 35px; background-color:white;";
        }
         
        /*if(document.getElementById("Tercero_idResponsable"+(actual)) && 
                (document.getElementById("Tercero_idResponsable"+(actual)).value == 0))  
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:red;";
            resp = false;
        }
        else
        {
            document.getElementById("Tercero_idResponsable"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:white;";
        }

        if(document.getElementById("Documento_idDocumento"+(actual)) && 
                (document.getElementById("Documento_idDocumento"+(actual)).value == 0))
        {
            document.getElementById("Documento_idDocumento"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:red;";
            resp = false;
        }
        else
        {
            document.getElementById("Documento_idDocumento"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:white;";
        }*/
    }

    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique, los campos resaltados en rojo son obligatorios');
    }

    return true;
}