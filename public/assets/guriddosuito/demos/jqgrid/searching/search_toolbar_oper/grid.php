<?php
require_once '../../jq-config.php';
// include the jqGrid Class
require_once ABSPATH."php/PHPSuito/jqGrid.php";
// include the driver class
require_once ABSPATH."php/PHPSuito/DBdrivers/jqGridPdo.php";
// include the datepicker
//require_once ABSPATH."php/jqCalendar.php";

// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT idPais, codigoPais, nombrePais FROM pais';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('grid.php');
// Set some grid options
$grid->setGridOptions(array(
	"caption"=>"Paises",
    "rowNum"=>3,
    "rowList"=>array(10,20,30),
    "sortname"=>"nombrePais",
    "multiSort"=>true,
    "sortable"=>true
	//"rowTotal"=>-1,
	//"loadonce"=>true
));


// Change some property of the field(s)
$grid->setColProperty("idPais", array(
	"searchoptions"=>array("sopt"=>array("eq","ne","le","lt","ge","gt")),
	"formatter"=>"integer",
	"formatoptions"=>array("thousandsSeparator"=>","),
	"label"=>"ID"
    )
);

$grid->setColProperty("codigoPais", array(
	"searchoptions"=>array("sopt"=>array("bw", "eq","ne","le","lt","ge","gt")),
	"label"=>"C&oacute;digo"
    )
);

$grid->setColProperty("nombrePais", array(
	"searchoptions"=>array("sopt"=>array("bw", "ne","le","lt","ge","gt")),
	"label"=>"Nombre"
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
//$grid->setSelect("nombrePais", "SELECT DISTINCT nombrePais AS nombrePais  FROM pais ORDER BY nombrePais", false, false, true, array(""=>"All"));
$grid->navigator = true;
$grid->setNavOptions('navigator', array("excel"=>false,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));

/*// Close the dialog after editing
$grid->setNavOptions('edit',array("closeAfterEdit"=>true,"editCaption"=>"Update Customer","bSubmit"=>"Update"));
// Enjoy

$form = <<< FORM
function(){
   var id = $("#grid").jqGrid('getGridParam','selrow'), data={};
   if(id) {
       data = {CustomerID:id};
   } else {
      alert('Please select a row to edit');
      return;
   }
   var ajaxDialog = $('<div id="ajax-dialog" style="display:hidden" title="Customer Edit"></div>').appendTo('body');
   ajaxDialog.load(
      'customer.php',
       data,
       function(response, status){
           ajaxDialog.dialog({
               width: 'auto',
               modal:true,
               open: function(ev, ui){
                  $(".ui-dialog").css('font-size','0.9em');
               },
               close: function(e,ui) {
                   ajaxDialog.remove();
               }
           });
            ajaxDialog.dialog('widget').css('font-size','12px');
        }
    );
}
FORM;

$buttonoptions = array("#pager",
    array(
      "caption"=>"Custom Edit Form",
      "onClickButton"=>"js:".$form
    )
);
$grid->callGridMethod("#grid", "navButtonAdd", $buttonoptions);*/

/*$bindkeys =<<<KEYS
$("#grid").bind('', function( event, form, oper ) {
alert('The operation is:'+oper);
});
KEYS;
$grid->setJSCode($bindkeys);
*/
// Adicional al funcionilidad de desplazamiento con teclado
$grid->callGridMethod('#grid', 'bindKeys');


// add a custom button via the build in callGridMethod
// note the js: before the function
$buttonoptions = array("#pager",
    array("caption"=>"Pdf", "title"=>"Exportar a Pdf", "onClickButton"=>"js: function(){
        jQuery('#grid').jqGrid('excelExport',{tag:'pdf', url:'grid.php'});}"
    )
);
$grid->callGridMethod("#grid", "navButtonAdd", $buttonoptions);

// Set it to toppager
$buttonoptions[0] = "#grid_toppager";
$grid->callGridMethod("#grid", "navButtonAdd", $buttonoptions);


// Enjoy
$grid->renderGrid('#grid','#pager',true, null, null, true,true);

