<?php 
	// Recibe ese id enviado por get
    $id = (isset($_GET['idLineaProducto']) ? $_GET['idLineaProducto'] : 0);
    
    $sublinea = DB::select(
    'SELECT nombreSublineaProducto,idSublineaProducto
    FROM sublineaproducto
    WHERE LineaProducto_idLineaProducto = '.$id);

    //  $sublineas= array();
    // for($i = 0; $i < count($sublinea); $i++) 
    // {
    //   $sublineas[] = get_object_vars($sublinea[$i]);
    // }
   

     echo json_encode($sublinea);
  
?>


