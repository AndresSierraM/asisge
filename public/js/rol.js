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
    this.nombreOpcion = new Array();
    this.valorOpcion = new Array();

};

Atributos.prototype.agregarCampos = function(datos, tipo, valorOpcion){

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

            input.value = valor[(tipo == 'A' ? i : this.campos[i])];
            input.setAttribute("class", this.clase[i]);
            input.setAttribute("style", this.estilo[i]);

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
            select.setAttribute("onfocus", this.eventofocus[i]);
            select.setAttribute("onkeyup", this.eventokeyup[i]);
            select.setAttribute("onclick", this.eventoclick[i]);
             
            for(var j=0,k=this.valorOpcion.length;j<k;j++)
            {
                option = document.createElement('option');
                option.value = this.valorOpcion[j];
                option.text = this.nombreOpcion[j];
                option.selected = (valor[i] == this.valorOpcion[j] ? true : false);
                select.appendChild(option);
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
            inputHidden.value = valor[i];
 
            divCheck.appendChild(inputHidden);
 
            var input = document.createElement('input');
            input.type = this.tipo[i];
            input.id =  this.campos[i]+'C'+this.contador;
            input.name =  this.campos[i]+'C'+'[]';
            input.checked = (valor[i] == 1 ? true : false);
            input.setAttribute("onfocus", this.eventofocus[i]);
            input.setAttribute("onkeyup", this.eventokeyup[i]);
            input.setAttribute("onclick", this.eventoclick[i]);
     
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
}

Atributos.prototype.borrarCampos = function(elemento){

    aux = elemento.parentNode;
    aux.removeChild(elemento);

}
