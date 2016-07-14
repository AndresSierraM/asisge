<?php 
$idCompania = \Session::get("idCompania");
$idUsuario = \Session::get("idUsuario");

$vista = (isset($_POST['vista']) ? $_POST['vista'] : 0);
$permiso = (isset($_POST['permiso']) ? $_POST['permiso'] : 0);

$datos = DB::select(
    'SELECT '.$permiso.'RolOpcion 
    FROM rolopcion RO
    left join opcion O
    on RO.Opcion_idOpcion = O.idOpcion
    left join users U
    on RO.Rol_idRol = U.Rol_idRol
    where   U.id = '.$idUsuario.' and 
            O.rutaOpcion = "'.$vista.'" and 
            '.$permiso.'RolOpcion = 1 and 
            U.Compania_idCompania = '.$idCompania .';');


echo (count($datos) > 0 ? 1 : 0);
?>