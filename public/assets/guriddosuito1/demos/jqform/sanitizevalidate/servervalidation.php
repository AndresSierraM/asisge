<?php
// Include class 
include_once '../jqformconfig.php'; 

include_once $CODE_PATH.'jqForm.php'; 
// Create instance 
$newForm = new jqForm('newForm',array('method' => 'post', 'id' => 'newForm'));
// Demo Mode creating connection 
include_once $DRIVER_PATH.'jqGridPdo.php'; 
$conn = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
$newForm->setConnection( $conn );
// Set url
$newForm->setUrl($SERVER_HOST.$SELF_PATH.'servervalidation.php');
// Set parameters 
$jqformparams = array();
// Set SQL Command, table, keys 
$newForm->table = 'orders';
$newForm->setPrimaryKeys('OrderID');
$newForm->serialKey = true;
// Set Form layout 
$newForm->setColumnLayout('twocolumn');
// Set the style for the table
$newForm->setTableStyles('width:100%;');

// Add elements
$newForm->addElement('OrderID','hidden', array('label' => 'OrderID', 'id' => 'newForm_OrderID'));
$newForm->addElement('ShipName','text', array('label' => 'ShipName', 'maxlength' => '40', 'style'=>'width:100%', 'id' => 'newForm_ShipName'));
$newForm->addElement('ShipAddress','text', array('label' => 'ShipAddress', 'maxlength' => '60', 'style'=>'width:100%', 'id' => 'newForm_ShipAddress'));
$newForm->addElement('ShipCity','text', array('label' => 'ShipCity', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCity'));
$newForm->addElement('ShipPostalCode','text', array('label' => 'ShipPostalCode', 'maxlength' => '10', 'size' => '20', 'id' => 'newForm_ShipPostalCode'));
$newForm->addElement('ShipCountry','text', array('label' => 'ShipCountry', 'maxlength' => '15', 'size' => '20', 'id' => 'newForm_ShipCountry'));
$newForm->addElement('Freight','number', array('label' => 'Freight', 'id' => 'newForm_Freight'));
$elem_8[]=$newForm->createElement('newSubmit','submit', array('value' => 'Submit'));
$newForm->addGroup("newGroup",$elem_8, array('style' => 'text-align:right;', 'id' => 'newForm_newGroup'));
// Add events
// Add ajax submit events
$newForm->setAjaxOptions( array(
'iframe' => false,
'forceSync' =>false) );

// Build server validations array
$validations = array(
    'ShipName' => array("text"=>true, "required"=>true, "sanitize"=>true),
	'Freight'=>array("number"=>true,"minValue"=>10,"maxValue"=>50, "sanitize"=>true)
);

// enable server validation
$newForm->serverValidate = true;
// enable server sanitation
$newForm->serverSanitize = true;

//set the rules
$newForm->setValidationRules($validations);


// Demo mode - no input 
$newForm->demo = true;
// Render the form 
echo $newForm->renderForm($jqformparams);
