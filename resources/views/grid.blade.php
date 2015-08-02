<!DOCTYPE html>
<html>
  <head>
    <title>jqGrid PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../public/assets/guriddosuito/css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../public/assets/guriddosuito/css/trirand/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../public/assets/guriddosuito/css/ui.multiselect.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
		
    </style>
    <script src="../../public/assets/guriddosuito/js/jquery.min.js" type="text/javascript"></script>
    <script src="../../public/assets/guriddosuito/js/trirand/i18n/grid.locale-en.js" type="text/javascript"></script>
	 	<script src="../../public/assets/guriddosuito/js/trirand/jquery.jqGrid.min.js" type="text/javascript"></script> <script type="text/javascript">   	  
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
	$.jgrid.defaults.width = "700";
	</script>
     
    <script src="../../public/assets/guriddosuito/js/jquery-ui.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
          <?php include ("paisgrid.blade.php");?>
      </div>

   </body>
</html>
