<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
	{!!Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
	{!!Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}
	{!!Html::style('assets/jquery-jqGrid-v4.8.0/css/ui.jqgrid.css'); !!}
	{!!Html::style('assets/tutorial/css/main.css'); !!}
	{!!Html::style('assets/tutorial/css/callouts.css'); !!}
	{!!Html::style('choosen/docsupport/style.css'); !!}
	{!!Html::style('choosen/docsupport/prism.css'); !!}
	{!!Html::style('choosen/chosen.css'); !!}
	<style type="text/css" media="all">
	    /* fix rtl for demo */
	    .chosen-rtl .chosen-drop { left: -9000px; }
  	</style>
	<!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	{!!Html::script('assets/tutorial/js/ie10-viewport-bug-workaround.js'); !!}
	{!!Html::script('assets/tutorial/js/ie-emulation-modes-warning.js'); !!}
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	{!!Html::script('assets/jquery-v2.1.4/jquery-2.1.4.min.js'); !!}
	{!!Html::script('assets/jquery-jqGrid-v4.8.0/js/i18n/grid.locale-en.js'); !!}
	{!!Html::script('assets/jquery-jqGrid-v4.8.0/js/jquery.jqGrid.src.js'); !!}
	{!!Html::script('assets/jquery-scrollto-v1.4.11/jquery.scrollTo.min.js'); !!}
	{!!Html::script('assets/bootstrap-v3.3.5/js/bootstrap.min.js'); !!}
	{!!Html::script('assets/jquery-jqMgVal-v0.1/jquery.jqMgVal.src.js'); !!}
	{!!Html::script('assets/tutorial/js/helpers.js'); !!}
	{!!Html::script('assets/tutorial/js/base.js'); !!}
	{!!Html::script('choosen/chosen.jquery.js'); !!}
  	{!!Html::script('choosen/docsupport/prism.js'); !!}
  	<script type="text/javascript">
    	$(document).ready(function (){
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
		});
  	</script>
	<title>Laravel jqGrid Tutorial</title>
</head>
<body id='body'>
	
	<div id='page-container' class="container" role="main" data-current-page-width="">
	<div class="row">

			@yield('content')
	</div>
	</div>
</body>
</html>