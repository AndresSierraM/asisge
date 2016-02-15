$(document).ready(function(){

	$('#menuarch').click(function(event){
		$('#arrowarch').slideToggle('slow');
		$('#gridboxarch').slideToggle('slow',function(){
			$('ul').animate({marginTop:'0'});
			$('#gridboxarch').animate();
		});
			event.stopPropagation();
	});
	
	$('#menudoc').click(function(event){
		$('#arrowdoc').slideToggle('slow');
		$("#gridboxdoc").css("position", "absolute"); 

		$('#gridboxdoc').slideToggle('slow',function(){
			//$('ul').animate({marginTop:'0'});
			$('#gridboxdoc').animate();
		});
			event.stopPropagation();
	});
	
	$('#menuseg').click(function(event){
		$('#arrowseg').slideToggle('slow');
		$("#gridboxseg").css("position", "absolute"); 

		$('#gridboxseg').slideToggle('slow',function(){
			//$('ul').animate({marginTop:'0'});
			$('#gridboxseg').animate({height:'200px'});
		});
			event.stopPropagation();
	});
	
	$('body').click(function() {
	
		$('#arrowarch').hide();
		$('#gridboxarch').hide();
		$('ul').animate({marginTop:'0'});
		$('#gridboxarch').animate();

		$('#arrowdoc').hide();
		$('#gridboxdoc').hide();
		$('ul').animate({marginTop:'0'});
		$('#gridboxdoc').animate();
		
		$('#arrowseg').hide();
		$('#gridboxseg').hide();
		$('ul').animate({marginTop:'0'});
		$('#gridboxseg').animate({height:'200px'});		
	});

});