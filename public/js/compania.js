var Atributos = function(nombreObjeto, nombreContenedor, nombreDiv){

    this.nombre = nombreObjeto;
    this.contenedor = nombreContenedor;
    this.contenido = nombreDiv;
    this.contador = 0;
    this.campos = new Array();
    this.tipo = new Array();
    this.estilo = new Array();
    this.clase = new Array();
    this.sololectura = new Array();
    this.etiqueta = new Array();

};

Atributos.prototype.agregarCampos = function(datos, tipo){


    console.log(datos+' antes');
    var valor;
    //if(tipo == 'A')
       valor = datos;
    //else
        valor = $.parseJSON(datos);
    
    console.log(valor+' despuess');
    var espacio = document.getElementById(this.contenedor);
    var caneca = document.createElement('a');
    var img = document.createElement('img');
    var div = document.createElement('div');
    div.id = this.contenido+this.contador;
    div.setAttribute("width", '100%');

    for (var i = 0,  e = this.campos.length; i < e ; i++)
    {
        var input = document.createElement('input');
        input.type =  this.tipo[i];
        input.id =  this.campos[i] + this.contador;
        input.name =  this.campos[i]+'[]';
        console.log(valor['Compania_idCompania']+' -- '+valor['nombreCompaniaObjetivo']+' -- '+valor[2]+' -- '+valor[3]+' -- '+valor[4]+' -- '+valor[5]+' ????????');
        input.value =  valor[this.campos[i]];
        input.setAttribute("class", this.clase[i]);
        input.setAttribute("style", this.estilo[i]);

        div.appendChild(input);

        caneca.setAttribute("style","margin: 12px");
        caneca.id = this.campos[i] + this.contador;
        caneca.setAttribute('onclick',this.nombre+'.borrarCampos('+this.contenido+this.contador+')');
        caneca.setAttribute("class","desactive");
        img.setAttribute("src","../images/eliminar.png");

    }
    caneca.appendChild(img);
    div.appendChild(caneca);
    espacio.appendChild(div);
    this.contador++;
}

Atributos.prototype.borrarCampos = function(elemento){

    aux = elemento.parentNode;
    aux.removeChild(elemento);

}