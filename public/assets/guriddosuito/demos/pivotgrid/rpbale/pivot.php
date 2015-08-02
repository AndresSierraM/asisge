<?php
require_once '../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/PHPSuito/jqGrid.php";
// include the driver class
require_once ABSPATH."php/PHPSuito/DBdrivers/jqGridArray.php";
// Connection to the server

//require_once ABSPATH."php/jqGridArray.php";

// create the array connection
$conn = new jqGridArray();
// Create the jqGrid instance
$pivot = new jqPivotGrid($conn);
// Create a random array data
$data1 = array();
for ($i = 0; $i < 100; $i++)
{
	$data1[$i]['CUSTOM']	= '703198';
	$data1[$i]['EVENT']	= 'Cloverleaf Spring Campout 2014';
	$data1[$i]['TRIBE']	= '1234'.($i+1);
	$data1[$i]['AGE'] = "AGE_".sprintf("%02d", rand(6,14));
	$data1[$i]['COUNTOFAGE'] = (int)rand(0,3);
}

// Always you can use SELECT * FROM data1
$pivot->SelectCommand = "SELECT * FROM data1 ORDER BY AGE";
// Set the url from where we obtain the data
$pivot->setData('pivot.php');

// Grid creation options
$pivot->setGridOptions(array(
	"rowNum"=>10,
	"height"=>200,
	"sortname" => "AGE",
	"shrinkToFit"=>false,
    "rowList"=>array(10,20,50),
	"caption"=>"Rows grouping"
));
// Grid xDimension settings
$pivot->setxDimension(array(
	array("dataName"=>"CUSTOM", "width"=>90),
	array("dataName" => "EVENT"),
	array("dataName" => "TRIBE")
));

// Grid yDimension settings
$pivot->setyDimension(array(
	array("dataName" => "AGE", "width"=>60)
));


// Members
$pivot->setaggregates(array(
	array(
		"member"=>'COUNTOFAGE',
		"aggregator"=>'sum',
		"width"=>80,
		"label"=>'Sum',
		"formatter"=>'integer',
		"align"=>'right',
		// the summary type set the sum function of the groups
		"summaryType"=>'sum'
	)
));

$pivot->renderPivot("#grid","#pager", true, null, true, true);
