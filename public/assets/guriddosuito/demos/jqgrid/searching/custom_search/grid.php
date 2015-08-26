<?php
require_once '../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/PHPSuito/jqGrid.php";
// include the driver class
require_once ABSPATH."php/PHPSuito/DBdrivers/jqGridPdo.php";
// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");

// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$search = jqGridUtils::GetParam('_search','false');
if($search == 'true')
{

	// get the date
	$from = jqGridUtils::GetParam('from','01/01/1994');
	$to = jqGridUtils::GetParam('to','12/31/1999');
	// Reformat it to DB appropriate search
	$from = jqGridUtils::parseDate('d/m/Y', $from, 'Y-m-d');
	$to = jqGridUtils::parseDate('d/m/Y', $to, 'Y-m-d');
	
	$_GET['_search'] = 'false';
	$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, ShipName, Freight FROM orders WHERE OrderDate >= "'.$from.'" AND OrderDate <= "'.$to.'"';
	//$grid->debug = true;
} else {
   // use the standard SelectCommand
	$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, ShipName, Freight FROM orders';
}
//$grid->SelectCommand = 'SELECT OrderID, OrderDate, CustomerID, ShipName, Freight FROM orders';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>10,
    "rowList"=>array(10,20,30),
    "sortname"=>"OrderID"
));
// Change some property of the field(s)
$grid->setColProperty("OrderDate", array(
    "formatter"=>"date",
    "formatoptions"=>array("srcformat"=>"Y-m-d H:i:s","newformat"=>"m/d/Y")
    )
);
$grid->setColProperty("ShipName", array("width"=>"200"));
// Enable navigator
$grid->navigator = true;
// Enable search
$grid->setNavOptions('navigator', array("search"=>false, "excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>false));
// Activate single search
//$grid->setNavOptions('search',array("multipleSearch"=>false));
// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);
$conn = null;
?>