<?php

         $competencia = DB::table('competencia')
            ->select(DB::raw('idCompetencia, nombreCompetencia'))
            ->get();
         

        $row = array();

    foreach ($competencia as $key => $value) 
    {  
        
        $row[$key][] = $value->idCompetencia;
        $row[$key][] = $value->nombreCompetencia;
        
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>