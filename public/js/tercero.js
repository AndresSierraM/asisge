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
    this.completar = new Array();
    this.etiqueta = new Array();
    this.opciones = new Array();
    this.funciones = new Array();
    this.nombreOpcion = new Array();
    this.valorOpcion = new Array();
    this.eventoclick = new Array();

};

Atributos.prototype.agregarCampos = function(datos, tipo){

    var valor;
    if(tipo == 'A')
       valor = datos;
    else
        valor = $.parseJSON(datos);
    
    var espacio = document.getElementById(this.contenedor);
    var caneca = document.createElement('div');
    var img = document.createElement('i');
    var div = document.createElement('div');
    div.id = this.contenido+this.contador;
    div.setAttribute("width", '100%');

    for (var i = 0,  e = this.campos.length; i < e ; i++)
    {
        if(this.etiqueta[i] == 'input')
        {
            var input = document.createElement('input');
            input.type =  this.tipo[i];
            input.id =  this.campos[i] + this.contador;
            input.name =  this.campos[i]+'[]';

            input.value = (typeof(valor[(tipo == 'A' ? i : this.campos[i])]) !== "undefined" ? valor[(tipo == 'A' ? i : this.campos[i])] : '');
            input.setAttribute("class", this.clase[i]);
            input.setAttribute("style", this.estilo[i]);
            input.readOnly = this.sololectura[i];
            input.autocomplete = this.completar[i];
            if(typeof(this.funciones[i]) !== "undefined") 
            {
                for(var h=0,c = this.funciones[i].length;h<c;h+=2) 
                {
                    input.setAttribute(this.funciones[i][h], this.funciones[i][h+1]);
                }
            }

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

            div.appendChild(input);
        }
        else if(this.etiqueta[i] == 'select')
        {
            var select = document.createElement('select');
            var option = '';
            select.id =  this.campos[i] + this.contador;
            select.name =  this.campos[i]+'[]';
            select.setAttribute("style", this.estilo[i]);
            select.setAttribute("class", this.clase[i]);

            if(typeof(this.funciones[i]) !== "undefined") 
            {
                for(var h=0,c = this.funciones[i].length;h<c;h+=2) 
                {
                    select.setAttribute(this.funciones[i][h], this.funciones[i][h+1]);
                }
            } 

            option = document.createElement('option');
            option.value = '';
            option.text = 'Seleccione...';
            select.appendChild(option);
            
            for(var j=0,k=this.opciones[i].length;j<k;j+=2)
            {
                for(var p=0,l = this.opciones[i][j].length;p<l;p++)
                {
                    option = document.createElement('option');
                    option.value = this.opciones[i][j][p];
                    option.text = this.opciones[i][j+1][p];

                    option.selected = (valor[(tipo == 'A' ? i : this.campos[i])] == this.opciones[i][j][p] ? true : false);
                    select.appendChild(option);
                }    
            }
 
            div.appendChild(select);

 
        }
        else if(this.etiqueta[i] == 'checkbox')
        {
            var divCheck = document.createElement('div');
            divCheck.setAttribute('class',this.clase[i]);
            divCheck.setAttribute('style',this.estilo[i]);
 
            var inputHidden = document.createElement('input');
            inputHidden.type =  'hidden';
            inputHidden.id =  this.campos[i] + this.contador;
            inputHidden.name =  this.campos[i]+'[]';
            inputHidden.value = valor[(tipo == 'A' ? i : this.campos[i])];
 
            divCheck.appendChild(inputHidden);
 
            var input = document.createElement('input');
            input.type = this.tipo[i];
            input.setAttribute('style',this.estilo[i]);
            input.id =  this.campos[i]+'C'+this.contador;
            input.name =  this.campos[i]+'C'+'[]';
            input.checked = (valor[(tipo == 'A' ? i : this.campos[i])] == 1 ? true : false);
            input.setAttribute("onclick", this.nombre+'.cambiarCheckbox("'+this.campos[i]+'",'+this.contador+')');
     
            divCheck.appendChild(input);
 
            div.appendChild(divCheck);
        }

    }

    caneca.id = 'eliminarRegistro'+ this.contador;
    caneca.setAttribute('onclick',this.nombre+'.borrarCampos('+this.contenido+this.contador+')');
    caneca.setAttribute("class","col-md-1");
    caneca.setAttribute("style","width:40px; height: 35px;");
    img.setAttribute("class","glyphicon glyphicon-trash");

    caneca.appendChild(img);
    div.appendChild(caneca);
    espacio.appendChild(div);

    this.contador++;

    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }

}

Atributos.prototype.borrarCampos = function(elemento){

    aux = elemento.parentNode;
    aux.removeChild(elemento);

}

Atributos.prototype.cambiarCheckbox = function(campo, registro)
{
    document.getElementById(campo+registro).value = document.getElementById(campo+"C"+registro).checked ? 1 : 0;
}


function validarTipoTercero()
{
    document.getElementById("tipoTercero").value = '';

    for (tipo = 1; tipo <= 2; tipo++)
    {
        document.getElementById("tipoTercero").value = document.getElementById("tipoTercero").value + ((document.getElementById("tipoTercero" + (tipo)).checked) ? '*' + document.getElementById("tipoTercero" + (tipo)).value + '*' : '');
    }
    mostrarPestanas();
}

function seleccionarTipoTercero()
{
    for (tipo = 1; tipo <= 2; tipo++)
    {
        if (document.getElementById("tipoTercero").value.indexOf('*' + document.getElementById("tipoTercero" + (tipo)).value + '*') >= 0)
        {
            document.getElementById("tipoTercero" + (tipo)).checked = true;
        }
        else
        {
            document.getElementById("tipoTercero" + (tipo)).checked = false;
        }
    }

    mostrarPestanas();

}

function llenaNombreTercero()
{
    nombre1 = document.getElementById('nombre1Tercero').value;
    nombre2 = document.getElementById('nombre2Tercero').value;
    apellido1 = document.getElementById('apellido1Tercero').value;
    apellido2 = document.getElementById('apellido2Tercero').value;

    document.getElementById('nombreCompletoTercero').value = nombre1 + ' ' + nombre2 + ' ' + apellido1 + ' ' + apellido2;
}

function mostrarPestanas()
{
    if(document.getElementById('tipoTercero1').checked)
    {
        document.getElementById('cargo').style.display = 'inline';
        document.getElementById('pestanaProducto').style.display = 'none';
        document.getElementById('pestanaEducacion').style.display = 'block';
        document.getElementById('pestanaExperiencia').style.display = 'block';
        document.getElementById('pestanaFormacion').style.display = 'block';
        document.getElementById('pestanaPersonal').style.display = 'block';
        document.getElementById('pestanaLaboral').style.display = 'block';
    }
    /*else
    {
        document.getElementById('cargo').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'block';   
        document.getElementById('pestanaEducacion').style.display = 'none';
        document.getElementById('pestanaExperiencia').style.display = 'none';
        document.getElementById('pestanaFormacion').style.display = 'none';
        document.getElementById('pestanaPersonal').style.display = 'none';
        document.getElementById('pestanaLaboral').style.display = 'none';
    }*/

    if(document.getElementById('tipoTercero2').checked)
    {
        document.getElementById('cargo').style.display = 'none';
        document.getElementById('pestanaProducto').style.display = 'block';
        document.getElementById('pestanaEducacion').style.display = 'none';
        document.getElementById('pestanaExperiencia').style.display = 'none';
        document.getElementById('pestanaFormacion').style.display = 'none';
        document.getElementById('pestanaPersonal').style.display = 'none';
        document.getElementById('pestanaLaboral').style.display = 'none';
    }
    /*else
    {
        document.getElementById('cargo').style.display = 'inline';
        document.getElementById('pestanaProducto').style.display = 'none';
        document.getElementById('pestanaEducacion').style.display = 'block';
        document.getElementById('pestanaExperiencia').style.display = 'block';
        document.getElementById('pestanaFormacion').style.display = 'block';
        document.getElementById('pestanaPersonal').style.display = 'block';
        document.getElementById('pestanaLaboral').style.display = 'block';
    }*/    
}