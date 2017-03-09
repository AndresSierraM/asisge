$(document).ready(function(){

//creamos la fecha actual
		var date = new Date();
		var yyyy = date.getFullYear().toString();
		var mm = (date.getMonth()+1).toString().length == 1 ? "0"+(date.getMonth()+1).toString() : (date.getMonth()+1).toString();
		var dd  = (date.getDate()).toString().length == 1 ? "0"+(date.getDate()).toString() : (date.getDate()).toString();

		//establecemos los valores del calendario
		var options = {
			events_source: 'http://'+location.host+'events/getAll',
			view: 'month',
			language: 'es-ES',
			tmpl_path: 'http://'+location.host+'/bower_components/bootstrap-calendar/tmpls/',
			tmpl_cache: false,
			day: yyyy+"-"+mm+"-"+dd,
			time_start: '10:00',
			time_end: '20:00',
			time_split: '30',
			width: '100%',
			onAfterEventsLoad: function(events) 
			{
				if(!events) 
				{
					return;
				}
				var list = $('#eventlist');
				list.html('');

				$.each(events, function(key, val) 
				{
					$(document.createElement('li'))
						.html('<a href="' + val.url + '">' + val.title + '</a>')
						.appendTo(list);
				});
			},
			onAfterViewLoad: function(view) 
			{
				$('.page-header h3').text(this.getTitle());
				$('.btn-group button').removeClass('active');
				$('button[data-calendar-view="' + view + '"]').addClass('active');
			},
			classes: {
				months: {
					general: 'label'
				}
			}
		};

		var calendar = $('#calendar').calendar(options);

		$('.btn-group button[data-calendar-nav]').each(function() 
		{
			var $this = $(this);
			$this.click(function() 
			{
				calendar.navigate($this.data('calendar-nav'));
			});
		});

		$('.btn-group button[data-calendar-view]').each(function() 
		{
			var $this = $(this);
			$this.click(function() 
			{
				calendar.view($this.data('calendar-view'));
			});
		});

		$('#first_day').change(function()
		{
			var value = $(this).val();
			value = value.length ? parseInt(value) : null;
			calendar.setOptions({first_day: value});
			calendar.view();
		});

		$('#events-in-modal').change(function()
		{
			var val = $(this).is(':checked') ? $(this).val() : null;
			calendar.setOptions(
				{
					modal: val,
					modal_type:'iframe'
				}
			);
		});
	// }(jQuery));
});

function agregarEvento()
{
	$('#modalEvento').modal('show');
}

function consultarCamposAgenda(idCategoriaAgenda)
{
	var token = document.getElementById('token').value;

	$.ajax({
		headers: {'X-CSRF-TOKEN': token},
        dataType: "json",
        data: {'idCategoriaAgenda' : idCategoriaAgenda},
        url:   'http://'+location.host+'/mostrarCamposAgenda/',
        type:  'post',
		success: function(respuesta)
		{
			// alert(respuesta.toSource());
        	for (var i = 0; i < respuesta.length; i++) 
        	{
        		if (respuesta[i]['nombreCampoCRM'] == 'ubicacionAgenda') 
        			$("#ubicacionAgenda").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'MovimientoCRM_idMovimientoCRM') 
        			$("#MovimientoCRM_idMovimientoCRM").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'Tercero_idResponsable') 
        			$("#Tercero_idResponsable").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'porcentajeEjecucionAgenda') 
        			$("#porcentajeEjecucionAgenda").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'estadoAgenda') 
        			$("#estadoAgenda").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'seguimientoAgenda') 
        			$("#seguimiento").css('display','block');
        			$("#liseguimiento").css('display','block');

        		if (respuesta[i]['nombreCampoCRM'] == 'Tercero_idAsistente') 
        			$("#asistentes").css('display','block');
        			$("#liasistentes").css('display','block');
        	}
    	}
	});
}

function guardarDatos(){

        var formId = '#agenda';

        var token = document.getElementById('token').value;
        $.ajax({
            async: true,
            headers: {'X-CSRF-TOKEN': token},
            url: $(formId).attr('action'),
            type: $(formId).attr('method'),
            data: $(formId).serialize(),
            dataType: 'html',
            success: function(result){
                $(formId)[0].reset();
                alert(result);
                $('#modalEvento').modal('hide');
            },
            error: function(){
                alert('No se pudo guardar el evento.');
            }
        });
}; 