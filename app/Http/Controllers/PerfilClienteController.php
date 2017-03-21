<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
include public_path().'/ajax/consultarPermisos.php';
use DB;

class PerfilClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vista = basename($_SERVER["PHP_SELF"]);
        $datos = consultarPermisos($vista);

        if($datos != null)
            return view('perfilclientegrid', compact('datos'));
        else
            return view('accesodenegado');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            
        $id = $_GET['idTercero'];
        // $perfilcliente = \App\Tercero::find($id);
        $cliente = DB::table('tercero')
                        ->leftJoin('terceroinformacion','tercero.idTercero','=','terceroinformacion.Tercero_idTercero')
                        ->leftJoin('terceroproducto','tercero.idTercero','=','terceroproducto.Tercero_idTercero')
                        ->leftJoin('tipoidentificacion','tercero.TipoIdentificacion_idTipoIdentificacion','=','tipoidentificacion.idTipoIdentificacion')
                        ->leftJoin('ciudad','tercero.Ciudad_idCiudad','=','ciudad.idCiudad')
                        ->leftJoin('zona','tercero.Zona_idZona','=','zona.idZona')
                        ->leftJoin('sectorempresa','tercero.SectorEmpresa_idSectorEmpresa','=','sectorempresa.idSectorEmpresa')
                        ->where('idTercero','=',$id)
                        ->get();

        $perfilcliente = get_object_vars($cliente[0]);

        return view('perfilcliente',compact('perfilcliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
