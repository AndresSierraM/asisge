
<!DOCTYPE html>
<html>
  <head>
    <title>jqGrid PHP Demo</title>
    <link rel="stylesheet" type="text/css" media="screen" href="../../../css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../css/trirand/ui.jqgrid.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../../../css/ui.multiselect.css" />
    <style type="text">
        html, body {
        margin: 0;			/* Remove body margin/padding */
    	padding: 0;
        overflow: hidden;	/* Remove scroll bars on browser window */
        font-size: 75%;
        }
		
    </style>
    <script src="../../../js/jquery.min.js" type="text/javascript"></script>
    <script src="../../../js/trirand/i18n/grid.locale-es.js" type="text/javascript"></script>
	 	<script src="../../../js/trirand/jquery.jqGrid.min.js" type="text/javascript"></script> <script type="text/javascript">   	  
	$.jgrid.no_legacy_api = true;
	$.jgrid.useJSON = true;
	$.jgrid.defaults.width = "700";
	</script>
     
    <script src="../../../js/jquery-ui.min.js" type="text/javascript"></script>
  </head>
  <body>
      <div>
          <?php 
// ** MySQL settings ** //
/*define('DB_DSN','mysql:host=localhost;dbname=asisge');
define('DB_USER', 'root');     // Your MySQL username
define('DB_PASSWORD', ''); // ...and password
define('DB_DATABASE', 'asisge'); // ...and password*/

//define('ABSPATH', '../../vendor/guriddosuito');
// Form settings
//$SERVER_HOST = "";        // the host name
//$SELF_PATH = "";    // the web path to the project without http
//$CODE_PATH = "../../vendor/guriddosuito/php/PHPSuito/"; // the physical path to the php files

// include the jqGrid Class
require_once "../../../php/PHPSuito/jqGrid.php";
// include the driver class
require_once "../../../php/PHPSuito/DBdrivers/jqGridPdo.php";
// include the datepicker
//require_once ABSPATH."php/jqCalendar.php";

// Connection to the server
$conn = new PDO('mysql:host=localhost;dbname=asisge','root','');
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT idPais as ID, codigoPais, nombrePais FROM pais';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('paisgrid.blade.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>3,
    "rowList"=>array(10,20,30),
    "sortname"=>"nombrePais"
  //"rowTotal"=>-1,
  //"loadonce"=>true
));

// Change some property of the field(s)
$grid->setColProperty("idPais", array(
  "searchoptions"=>array("sopt"=>array("eq","ne","le","lt","ge","gt")),
    )
);


$grid->setColProperty("codigoPais", array(
  "searchoptions"=>array("sopt"=>array("eq","ne","le","lt","ge","gt")),
    )
);

$grid->setColProperty("nombrePais", array(
  "searchoptions"=>array("sopt"=>array("eq","ne","le","lt","ge","gt")),
    )
);


// Set the dates
$grid->setUserDate('d.m.Y');
$grid->setUserTime('d.m.Y');

$grid->setDbDate('Y-m-d');
$grid->setDbTime('Y-m-d');

// Set the datepicker
$grid->setDatepicker( "RequiredDate" );
// In this case no need to set a mm/dd/yyyy - it is get autoamatically from setUserDate


//and finaly set it to the grid
$grid->datearray= array( "RequiredDate" );
// Enable filter toolbar searching
$grid->toolbarfilter = true;
// Enable operation search
$grid->setFilterOptions(array("searchOperators"=>true));

// we set the select for ship city
$grid->setSelect("nombrePais", "SELECT DISTINCT nombrePais AS nombrePais  FROM pais ORDER BY nombrePais", false, false, true, array(""=>"All"));
$grid->navigator = true;
$grid->setNavOptions('navigator', array("excel"=>true,"add"=>true,"edit"=>true,"del"=>true,"view"=>true, "search"=>true));

//Trigger toolbar with custom button
$search = <<<SEARCH
jQuery("#searchtoolbar").click(function(){
  jQuery('#grid')[0].triggerToolbar();
  return false;
});
SEARCH;
$grid->setJSCode($search);
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);


          ?>
      </div>
	  
      
   </body>
</html>