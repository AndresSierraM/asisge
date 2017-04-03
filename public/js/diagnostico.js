var Atributos = function(nombreObjeto, nombreContenedor, nombreDiv){

    this.nombre = nombreObjeto;
    this.contenedor = nombreContenedor;
    this.contenido = nombreDiv;
    this.contador = 0;
    this.campos = new Array();
    this.etiqueta = new Array();
    this.tipo = new Array();
    this.estilo = new Array();
    this.clase = new Array();
    this.sololectura = new Array();
    this.etiqueta = new Array();
    this.calculo = new Array();

};

var Titulos = function(titnombreObjeto, titnombreContenedor, titnombreDiv){

    this.nombre = titnombreObjeto;
    this.contenedor = titnombreContenedor;
    this.contenido = titnombreDiv;
    this.contador = 0;
    this.texto = new Array();
    this.estilo = new Array();
    this.clase = new Array();
};


Atributos.prototype.agregarCampos = function(datos, tipo, grupo){

    var valor;
    if(tipo == 'A')
       valor = datos;
    else
        valor = $.parseJSON(datos);
    
    var espacio = document.getElementById(this.contenedor+grupo);
    var div = document.createElement('div');
    div.id = this.contenido+this.contador;
    div.setAttribute("width", '100%');
    for (var  i = 0,  e = this.campos.length; i < e ; i++)
    {

        if(this.etiqueta[i] == 'input')
        {
            var input = document.createElement('input');
            input.type =  this.tipo[i];
            input.id =  this.campos[i] + this.contador;
            input.name =  this.campos[i]+'[]';

            input.value = valor[(tipo == 'A' ? i : this.campos[i])];
            input.setAttribute("class", this.clase[i]);
            input.setAttribute("style", this.estilo[i]);


            if(this.sololectura[i] === true)
                input.setAttribute("readOnly", "readOnly");
            
            if(this.calculo[i])
                input.addEventListener("blur", calcularResultado, false);



           
            div.appendChild(input); 

           
        }
        else if(this.etiqueta[i] == 'textarea')
        {
            var input = document.createElement('textarea');
            input.id =  this.campos[i] + this.contador;
            input.name =  this.campos[i]+'[]';

            input.value = valor[(tipo == 'A' ? i : this.campos[i])];
            input.setAttribute("class", this.clase[i]);
            input.setAttribute("style", this.estilo[i]);
            if(this.sololectura[i] === true)
                input.setAttribute("readOnly", "readOnly");

            
            if(typeof(this.funciones[i]) !== "undefined") 
            {
                for(var h=0,c = this.funciones[i].length;h<c;h+=2) 
                {
                    input.setAttribute(this.funciones[i][h], this.funciones[i][h+1]);
                }
            }
            
            div.appendChild(input);
        }

    }

   
    espacio.appendChild(div);
    this.contador++;
}


Titulos.prototype.agregarTitulos = function(grupo, nombreGrupo){

    // cada que adicione titulos del detalle, los creamos dentro del div detalles
    // y el nombre de cada div, va a set el nombre del contenedor + id del grupo de preguntas
    // este mismo div, nos va a servir para adicionar los div de titulos y los div de datos
    var espacio = document.getElementById('detalle');
    var divpadre = document.createElement('div');
    divpadre.id = this.contenedor+grupo;
    divpadre.setAttribute("class", 'row show-grid');
    divpadre.setAttribute("width", '100%');
    espacio.appendChild(divpadre);

    var espacio = document.getElementById(this.contenedor+grupo);
    
    var div = document.createElement('div');
    div.id = this.contenido+this.contador;
    div.setAttribute("width", '100%');
    
    var label = document.createElement('div');
    label.setAttribute("class", this.clase[0] );
    label.setAttribute("style", "width: 1120px;");
    label.innerHTML = nombreGrupo;
    div.appendChild(label);

    for (var i = 0,  e = this.texto.length; i < e ; i++)
    {
    
            var label = document.createElement('div');
            label.setAttribute("class", this.clase[i] );
            label.setAttribute("style", this.estilo[i]);
            label.innerHTML = this.texto[i];
            div.appendChild(label);
    }

    espacio.appendChild(div);
    this.contador++;
}

function validarFormularioREQUEST(event)
{
    var route = "http://"+location.host+"/diagnostico";
    var token = $("#token").val();
    var dato0 = document.getElementById('idDiagnostico').value;
    var dato1 = document.getElementById('codigoDiagnostico').value;
    var dato2 = document.getElementById('nombreDiagnostico').value;
    var dato3 = document.getElementById('fechaElaboracionDiagnostico').value;
    var datoPuntuacion = document.querySelectorAll("[name='puntuacionDiagnosticoDetalle[]']");
    var dato4 = [];
    console.log(dato1);
    var valor = '';
    var sw = true;
    for(var j=0,i=datoPuntuacion.length; j<i;j++)
    {
        //console.log(j+' -> '+datoPuntuacion[j].value+"\n");
        dato4[j] = datoPuntuacion[j].value;
    }

    $.ajax({
        async: false,
        url:route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {respuesta: 'falso',
                idDiagnostico: dato0,
                codigoDiagnostico: dato1,
                nombreDiagnostico: dato2,
                fechaElaboracionDiagnostico: dato3,
                puntuacionDiagnosticoDetalle: dato4
                },
        success:function(){
            //$("#msj-success").fadeIn();
            //console.log(' sin errores');
        },
        error:function(msj){
            var mensaje = '';
            //console.log(msj.responseJSON);
            var respuesta = JSON.stringify(msj.responseJSON); 
            //console.log(respuesta);
            if(typeof respuesta === "undefined")
            {
                sw = false;
                $("#msj").html('');
                $("#msj-error").fadeOut();
                $("#Grabar").click();
            }
            else
            {
                sw = true;
                respuesta = JSON.parse(respuesta);

                (typeof msj.responseJSON.codigoDiagnostico === "undefined" ? document.getElementById('codigoDiagnostico').style.borderColor = '' : document.getElementById('codigoDiagnostico').style.borderColor = '#a94442');
                (typeof msj.responseJSON.nombreDiagnostico === "undefined" ? document.getElementById('nombreDiagnostico').style.borderColor = '' : document.getElementById('nombreDiagnostico').style.borderColor = '#a94442');
                (typeof msj.responseJSON.fechaElaboracionDiagnostico === "undefined" ? document.getElementById('fechaElaboracionDiagnostico').style.borderColor = '' : document.getElementById('fechaElaboracionDiagnostico').style.borderColor = '#a94442');

                for(var j=0,i=datoPuntuacion.length; j<i;j++)
                {

                    (typeof respuesta['puntuacionDiagnosticoDetalle'+j] === "undefined" ? document.getElementById('puntuacionDiagnosticoDetalle'+j).style.borderColor = '' : document.getElementById('puntuacionDiagnosticoDetalle'+j).style.borderColor = '#a94442');
                }
                $("#msj").html('Los campos bordeados en rojo son obligatorios.'+respuesta['puntuacionDiagnosticoDetalle0']);
                $("#msj-error").fadeIn();
            }

        }
    });

    //if(sw === true)
        event.preventDefault();
}


function calcularResultado()
{
  var cambio = "document.getElementById('"+this.id.replace('puntuacionDiagnosticoDetalle','resultadoDiagnosticoDetalle') + "').value = "+this.value+" * 20;";
  eval(cambio);
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
        if(document.getElementById("puntuacionDiagnosticoDetalle"+(actual)) && 
            (document.getElementById("puntuacionDiagnosticoDetalle"+(actual)).value < 0 ||  
            document.getElementById("puntuacionDiagnosticoDetalle"+(actual)).value > 5))
        {
            document.getElementById("puntuacionDiagnosticoDetalle"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:#F5A9A9;";
            resp = false;
            
        } 
        else
        {
            document.getElementById("puntuacionDiagnosticoDetalle"+(actual)).style = "height: 60px; text-align: center; vertical-align: top; width: 100px; background-color:white;";
        } 
    }

    if(resp === true)
    {
        $("form").submit();
    }
    else
    {
        alert('Por favor verifique las puntuaciones resaltadas en rojo, deben ser valor 0 (No aplica) o valores entre 1 y 5 (siendo 1 que no se cumple y 5 que cumple totalmente con el aspecto evaluado)');
    }

    return true;
}