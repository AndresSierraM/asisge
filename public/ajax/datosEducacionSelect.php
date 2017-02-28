<?php

        $educacion = DB::table('perfilcargo')
            ->select(DB::raw('idPerfilCargo,nombrePerfilCargo,Compania_idCompania'))
            ->where('tipoPerfilCargo','=','Educacion')
            ->where('perfilcargo.Compania_idCompania',"=", \Session::get("idCompania"))
            ->get();
    
        $row = array();

    foreach ($educacion as $key => $value) 
    {  
        
        $row[$key][] = $value->idPerfilCargo;
        $row[$key][] = $value->nombrePerfilCargo;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>