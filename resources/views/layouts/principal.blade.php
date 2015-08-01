<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{!! Html::style('assets/bootstrap-v3.3.5/css/bootstrap.min.css'); !!}
	{!! Html::style('assets/bootstrap-v3.3.5/css/bootstrap-theme.min.css'); !!}
	{!! Html::style('assets/font-awesome-v4.3.0/css/font-awesome.min.css'); !!}
	{!! Html::style('assets/jquery-ui-v1.11.4/css/smoothness/jquery-ui-1.10.3.custom.css'); !!}
	{!! Html::style('assets/jquery-jqGrid-v4.8.0/css/ui.jqgrid.css'); !!}
	{!! Html::style('assets/tutorial/css/main.css'); !!}
	{!! Html::style('assets/tutorial/css/callouts.css'); !!}
	<!--[if lt IE 9]><script src="../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	{!! Html::script('assets/tutorial/js/ie10-viewport-bug-workaround.js'); !!}
	{!! Html::script('assets/tutorial/js/ie-emulation-modes-warning.js'); !!}
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	{!! Html::script('assets/jquery-v2.0.3/jquery.js'); !!}
	{!! Html::script('assets/jquery-ui-v1.11.4/dev/minified/jquery.ui.effect.min.js'); !!}
	{!! Html::script('assets/jquery-ui-v1.11.4/dev/minified/jquery.ui.effect-shake.min.js'); !!}
	{!! Html::script('assets/jquery-jqGrid-v4.8.0/js/i18n/grid.locale-en.js'); !!}
	{!! Html::script('assets/jquery-jqGrid-v4.8.0/js/jquery.jqGrid.src.js'); !!}
	{!! Html::script('assets/jquery-scrollto-v1.4.11/jquery.scrollTo.min.js'); !!}
	{!! Html::script('assets/bootstrap-v3.2.0/js/bootstrap.min.js'); !!}
	{!! Html::script('assets/jquery-jqMgVal-v0.1/jquery.jqMgVal.src.js'); !!}
	{!! Html::script('assets/tutorial/js/helpers.js'); !!}
	{!! Html::script('assets/tutorial/js/base.js'); !!}
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