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

};

Atributos.prototype.agregarCampos = function(datos, tipo){


    
    var valor;
    if(tipo == 'A')
       valor = datos;
    else
        valor = $.parseJSON(datos);
    
    
    var espacio = document.getElementById(this.contenedor);
    var caneca = document.createElement('a');
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

        if(this.etiqueta[i] == 'textarea')
        {    
            var input = document.createElement('textarea');
            input.id =  this.campos[i] + this.contador;
            input.name =  this.campos[i]+'[]';
            
            input.value = valor[(tipo == 'A' ? i : this.campos[i])];
            input.setAttribute("class", this.clase[i]);
            input.setAttribute("style", this.estilo[i]);

            div.appendChild(input);
        }

    }

    caneca.id = 'eliminarRegistro'+ this.contador;
    caneca.setAttribute('onclick',this.nombre+'.borrarCampos('+this.contenido+this.contador+')');
    caneca.setAttribute("class","col-md-1");
    caneca.setAttribute("style","width:40px; height: 80px;");
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