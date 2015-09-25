<?php
//------------------------------------
// CONFIGURACION DE LA BASE DE DATOS
//------------------------------------
//define('DB_DSN','mysql:host=localhost;dbname=asisge');
//define('DB_USER', 'root');     // Your MySQL username
//define('DB_PASSWORD', ''); // ...and password
//define('DB_DATABASE', 'asisge'); // ...and password
// Ruta absoluta de las librearias de la Grid
define('ABSPATH', '../public/assets/guriddosuito/');
// configuracion de formulario
//$SERVER_HOST = "";        // the host name
//$SELF_PATH = "";    // the web path to the project without http
//$CODE_PATH = "../../public/assets/guriddosuito/php/PHPSuito/"; // the physical path to the php files
// inclusion de la clase jqGrid
require_once "../public/assets/guriddosuito/php/PHPSuito/jqGrid.php";
// inclusion de l driver de la clase 
require_once "../public/assets/guriddosuito/php/PHPSuito/DBdrivers/jqGridPdo.php";
// inclusion del datepicker
//require_once ABSPATH."php/jqCalendar.php";
// Conexion al servidor de BD
$conn = new PDO(env('DB_DSN', false),env('DB_USERNAME', false),env('DB_PASSWORD', false));
// Indicar a la base de datos el uso de UTF8
$conn->query("SET NAMES utf8");
// Crear la instancia de la GRID
$grid = new jqGridRender($conn);
// Escribir la consulta SQL a mostrar en la grid
$grid->SelectCommand = 'SELECT idMatrizLegal, nombreMatrizLegal, fechaElaboracionMatrizLegal, origenMatrizLegal, name
                        FROM matrizlegal ML
                        LEFT JOIN users U
                        ON ML.Users_id = U.id';
// Establecer el formato de salida en JSON
$grid->dataType = 'json';
// Permitir que la grid cree el modelo
$grid->setColModel();
// establecer la URL desde donde se obtienen los datos
$grid->setUrl('matrizlegalgrid');
// SetOpciones de la grid
$grid->setGridOptions(array(
    "rowNum"=>30,
    "rowList"=>array(30,50,100),
    "sortname"=>"nombreMatrizLegal",
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
$grid->setColProperty("idMatrizLegal", array(
  "searchoptions"=>array("sopt"=>array("eq","ne","le","lt","ge","gt")),
  "formatter"=>"integer",
  "formatoptions"=>array("thousandsSeparator"=>","),
  "label"=>"ID"
    )
);
$grid->setColProperty("nombreMatrizLegal", array(
  "searchoptions"=>array("sopt"=>array("bw", "eq","ne","le","lt","ge","gt")),
  "label"=>"Nombre"
    )
);
$grid->setColProperty("fechaElaboracionMatrizLegal", array(
  "searchoptions"=>array("sopt"=>array("bw", "ne","le","lt","ge","gt")),
  "label"=>"Fecha Elaboraci&oacute;n"
    )
);
$grid->setColProperty("origenMatrizLegal", array(
  "searchoptions"=>array("sopt"=>array("bw", "ne","le","lt","ge","gt")),
  "label"=>"Origen"
    )
);
$grid->setColProperty("name", array(
  "searchoptions"=>array("sopt"=>array("bw", "ne","le","lt","ge","gt")),
  "label"=>"Usuario"
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
        window.location.href = 'matrizlegal/create'}"
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
          window.location.href = 'matrizlegal/'+id+'/edit';
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
          window.location.href = 'matrizlegal/'+id+'/edit?accion=eliminar';
        } else {
          alert('Por favor seleccione el registro a Eliminar');
          return;
        }
        
      }"
    )
);

$grid->callGridMethod("#grid", "navButtonAdd", $buttoneliminar);

$buttonimprimir = array("#pager",
    array("caption"=>"Imprimir", "title"=>"Imprimir el registro", 
      "onClickButton"=>"js: function(){
        var id = $('#grid').jqGrid('getGridParam','selrow'), data={};
        if(id) {
          window.open('matrizlegal/'+id+'?accion=imprimir','Formato','width=5000,height=5000,scrollbars=yes, status=0, toolbar=0, location=0, menubar=0, directories=0');
          
        } else {
          alert('Por favor seleccione el registro a Imprimir');
          return;
        }
        
      }"
    )
);
$grid->callGridMethod("#grid", "navButtonAdd", $buttonimprimir);
// Ejecutamos la grid
$grid->renderGrid('#grid','#pager',true, null, null, true,true);