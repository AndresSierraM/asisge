<?php
// ** MySQL settings ** //
//define('DB_NAME', 'northwind');    // The name of the database
//define('DB_HOST', 'localhost');    // 99% chance you won't need to change this value
define('DB_DSN','mysql:host=localhost;dbname=asisge');
define('DB_USER', 'root');     // Your MySQL username
define('DB_PASSWORD', ''); // ...and password
define('DB_DATABASE', 'asisge'); // ...and password

define('ABSPATH', '../public/assets/guriddosuito/');
// Form settings
$SERVER_HOST = "";        // the host name
$SELF_PATH = "";    // the web path to the project without http
$CODE_PATH = "../../public/assets/guriddosuito/php/PHPSuito/"; // the physical path to the php files
// include the jqGrid Class
require_once "../public/assets/guriddosuito/php/PHPSuito/jqGrid.php";
// include the driver class
require_once "../public/assets/guriddosuito/php/PHPSuito/DBdrivers/jqGridPdo.php";
// include the datepicker
//require_once ABSPATH."php/jqCalendar.php";

// Connection to the server
$conn = new PDO(DB_DSN,DB_USER,DB_PASSWORD);
// Tell the db that we use utf-8
$conn->query("SET NAMES utf8");
// Create the jqGrid instance
$grid = new jqGridRender($conn);
// Write the SQL Query
$grid->SelectCommand = 'SELECT idDepartamento, codigoDepartamento, nombreDepartamento, P.nombrePais 
                        FROM Departamento D
                        LEFT JOIN Pais P
                        ON D.Pais_idPais = P.idPais';
// Set output format to json
$grid->dataType = 'json';
// Let the grid create the model
$grid->setColModel();
// Set the url from where we obtain the data
$grid->setUrl('departamentogrid');
// Set some grid options
$grid->setGridOptions(array(
    "rowNum"=>30,
    "rowList"=>array(30,50,100),
    "sortname"=>"nombreDepartamento",
    "multiSort"=>true,
    "sortable"=>true,
    "altRows"=>true,
    "hoverrows"=>true,
    //"rowTotal"=>-1,
    //"loadonce"=>true
));


// ----------------------------------------------------
// P R O P I E D A D E S   D E   L O S   C A M P O S
// ----------------------------------------------------

$grid->setColProperty("idDepartamento", array(
  "searchoptions"=>array("sopt"=>array("eq","ne","le","lt","ge","gt")),
  "formatter"=>"integer",
  "formatoptions"=>array("thousandsSeparator"=>","),
  "label"=>"ID"
    )
);

$grid->setColProperty("codigoDepartamento", array(
  "searchoptions"=>array("sopt"=>array("bw", "eq","ne","le","lt","ge","gt")),
  "label"=>"C&oacute;digo"
    )
);

$grid->setColProperty("nombreDepartamento", array(
  "searchoptions"=>array("sopt"=>array("bw", "ne","le","lt","ge","gt")),
  "label"=>"Nombre"
    )
);

$grid->setColProperty("nombrePais", array(
  "searchoptions"=>array("sopt"=>array("bw", "ne","le","lt","ge","gt")),
  "label"=>"Pais"
    )
);

// Formatos de fecha
$grid->setUserDate('d.m.Y');
$grid->setUserTime('d.m.Y');
$grid->setDbDate('Y-m-d');
$grid->setDbTime('Y-m-d');
// poner el datepicker como obligatorio en caso de que se use
$grid->setDatepicker( "RequiredDate" );
$grid->datearray= array( "RequiredDate" );

// habilitar la barra de herramientas de busquedas (boton en la barra que llama formulario de filtros)
$grid->toolbarfilter = true;
// habilitar operaciones de busqueda (en las columnas)
$grid->setFilterOptions(array("searchOperators"=>true));

// habilitar la barra de navegacion
$grid->navigator = true;
// indicamos a la barra de navegacion que botones utiliza
$grid->setNavOptions('navigator', array("excel"=>true,"add"=>false,"edit"=>false,"del"=>false,"view"=>true, "search"=>true));

// Adicional al funcionalidad de desplazamiento con teclado
$grid->callGridMethod('#grid', 'bindKeys');


//------------------------------
// B O T O N   A D I C I O N A R 
//------------------------------
$buttonadicionar = array("#pager",
    array("caption"=>"Adicionar", "title"=>"Adicionar un nuevo registro", "onClickButton"=>"js: function(){
        window.location.href = 'departamento/create'}"
    )
);
$grid->callGridMethod("#grid", "navButtonAdd", $buttonadicionar);


//------------------------------
// B O T O N   E D I T A R
//------------------------------
$buttonmodificar = array("#pager",
    array("caption"=>"Modificar", "title"=>"Modificar el registro", 
      "onClickButton"=>"js: function(){
        var id = $('#grid').jqGrid('getGridParam','selrow'), data={};
        if(id) {
          window.location.href = 'departamento/'+id+'/edit';
        } else {
          alert('Por favor seleccione el registro a Editar');
          return;
        }
        
      }"
    )
);
$grid->callGridMethod("#grid", "navButtonAdd", $buttonmodificar);


//------------------------------
// B O T O N   E L I M I N A R
//------------------------------
$buttoneliminar = array("#pager",
    array("caption"=>"Eliminar", "title"=>"Eliminar el registro", 
      "onClickButton"=>"js: function(){
        var id = $('#grid').jqGrid('getGridParam','selrow'), data={};
        if(id) {
          window.location.href = 'departamento/'+id+'/edit?accion=eliminar';
        } else {
          alert('Por favor seleccione el registro a Eliminar');
          return;
        }
        
      }"
    )
);
$grid->callGridMethod("#grid", "navButtonAdd", $buttoneliminar);

// Ejecutamos la grid
$grid->renderGrid('#grid','#pager',true, null, null, true,true);