function validarPesoEvaluacion()
{
    var total = 0;

    for (var i = 0; i < evaluacion.contador; i++) 
    {
        total = total + parseFloat($('#pesoTipoProveedorEvaluacion'+[i]).val());
    }

    if (total >100 || total < 100)
        $("#totalevaluacion").html('La sumatoria debe ser 100. Valor actual '+total).css("font-weight","bold").css('display', 'block');
    else if (total === 100) 
        $("#totalevaluacion").html('La sumatoria debe ser 100. Valor actual '+total).css("font-weight","bold").css('display', 'none');
}