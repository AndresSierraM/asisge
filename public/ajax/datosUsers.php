<?php


    $users = DB::table('users')
            ->leftJoin('compania', 'Compania_idCompania', '=', 'idCompania')
            ->select(DB::raw('id, name, email, nombreCompania'))
            ->where('users.Compania_idCompania','=', \Session::get('idCompania'))
            ->get();

    //print_r($users);
    // exit;
    $row = array();

    foreach ($users as $key => $value) 
    {  
        $row[$key][] = '<a href="users/'.$value->id.'/edit">'.
                            '<span class="glyphicon glyphicon-pencil"></span>'.
                        '</a>&nbsp;'.
                        '<a href="users/'.$value->id.'/edit?accion=eliminar">'.
                            '<span class="glyphicon glyphicon-trash"></span>'.
                        '</a>';
        $row[$key][] = $value->id;
        $row[$key][] = $value->name;
        $row[$key][] = $value->email; 
        $row[$key][] = $value->nombreCompania;    
    }

    $output['aaData'] = $row;
    echo json_encode($output);
?>