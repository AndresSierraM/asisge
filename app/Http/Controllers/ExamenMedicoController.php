<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamenMedico;
use App\Http\Requests;
use App\Http\Requests\ExamenMedicoRequest;
use App\Http\Controllers\Controller;
use DB;

class ExamenMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        
        return view('examenmedicogrid');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $idTipoExamenMedico = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamenMedico = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');


        return view('examenmedico',compact('idTipoExamenMedico','nombreTipoExamenMedico','tercero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ExamenMedicoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            \App\ExamenMedico::create([
                'Tercero_idTercero' => $request['Tercero_idTercero'],
                'fechaExamenMedico' => $request['fechaExamenMedico'],
                'tipoExamenMedico' => $request['tipoExamenMedico']
                ]); 

            $examenmedico = \App\ExamenMedico::All()->last();
            $contadorDetalle = count($request['TipoExamenMedico_idTipoExamenMedico']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ExamenMedicoDetalle::create([
                'ExamenMedico_idExamenMedico' => $examenmedico->idExamenMedico,
                'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i],
                'resultadoExamenMedicoDetalle' => $request['resultadoExamenMedicoDetalle'][$i],
                'observacionExamenMedicoDetalle' => $request['observacionExamenMedicoDetalle'][$i]
               ]);
                
            }

           return redirect('/examenmedico');
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request)
    {
        

        // si recibe el tipo de examen medico (no el id sino la lista que indica si es de ingreso, retiro o periodico)
        // entonces devolvemos una consulta de los nombres de examenes medicos que coninciden con dicha información
        if(isset($request['consulta']))
        {
            $cargo = DB::table('tercero')
                    ->leftJoin('cargo', 'tercero.Cargo_idCargo', '=', 'cargo.idCargo')
                    ->select(DB::raw('idCargo, nombreCargo'))
                    ->where('tercero.idTercero','=',$request["idTercero"])
                    ->get();
            if($request['consulta'] == 'Examen')
            {
                
                $examenmedicotercero = DB::table('terceroexamenmedico')
                    ->leftJoin('tipoexamenmedico', 'terceroexamenmedico.TipoExamenMedico_idTipoExamenMedico', '=', 'tipoexamenmedico.idTipoExamenMedico')
                    ->select(DB::raw('idTipoExamenMedico as TipoExamenMedico_idTipoExamenMedico, nombreTipoExamenMedico, limiteInferiorTipoExamenMedico, limiteSuperiorTipoExamenMedico, "" as resultadoExamenMedicoDetalle, "" as observacionExamenMedicoDetalle'))
                    ->orderBy('nombreTipoExamenMedico', 'ASC')
                    ->where('terceroexamenmedico.Tercero_idTercero','=',$request["idTercero"])
                    ->where('terceroexamenmedico.'.$request["tipoExamenMedico"].'TerceroExamenMedico','=',1)
                    ->get();

                $examenmedicocargo = DB::table('cargoexamenmedico')
                    ->leftJoin('tipoexamenmedico', 'cargoexamenmedico.TipoExamenMedico_idTipoExamenMedico', '=', 'tipoexamenmedico.idTipoExamenMedico')
                    ->select(DB::raw('idTipoExamenMedico as TipoExamenMedico_idTipoExamenMedico, nombreTipoExamenMedico, limiteInferiorTipoExamenMedico, limiteSuperiorTipoExamenMedico, "" as resultadoExamenMedicoDetalle, "" as observacionExamenMedicoDetalle'))
                    ->orderBy('nombreTipoExamenMedico', 'ASC')
                    ->where('cargoexamenmedico.Cargo_idCargo','=',$request["idCargo"])
                    ->where('cargoexamenmedico.'.$request["tipoExamenMedico"].'CargoExamenMedico','=',1)
                    ->get();

                if($request->ajax())
                {
                    return response()->json([$examenmedicotercero, $examenmedicocargo, $cargo]);
                }
            }
            else
            {
                if($request->ajax())
                {
                    return response()->json([$cargo]);
                }
            }
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {

        $idTipoExamenMedico = \App\TipoExamenMedico::All()->lists('idTipoExamenMedico');
        $nombreTipoExamenMedico = \App\TipoExamenMedico::All()->lists('nombreTipoExamenMedico');

        $tercero = \App\Tercero::All()->lists('nombreCompletoTercero','idTercero');

        $examenmedico = \App\ExamenMedico::find($id);
        $examenesmedicos = DB::table('examenmedicodetalle')
            ->leftJoin('tipoexamenmedico', 'examenmedicodetalle.TipoExamenMedico_idTipoExamenMedico', '=', 'tipoexamenmedico.idTipoExamenMedico')
            ->select(DB::raw('TipoExamenMedico_idTipoExamenMedico, nombreTipoExamenMedico, limiteInferiorTipoExamenMedico, limiteSuperiorTipoExamenMedico, resultadoExamenMedicoDetalle, observacionExamenMedicoDetalle'))
            ->orderBy('nombreTipoExamenMedico', 'ASC')
            ->where('ExamenMedico_idExamenMedico','=',$id)
            ->get();

       return view('examenmedico',compact('idTipoExamenMedico','nombreTipoExamenMedico','tercero'),['examenesmedicos'=>$examenesmedicos, 'examenmedico' => $examenmedico]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($id, ExamenMedicoRequest $request)
    {
        if($request['respuesta'] != 'falso')
        {
            $examenmedico = \App\ExamenMedico::find($id);
            $examenmedico->fill($request->all());
            //$examenmedico->Compania_idCompania = 1;
            $examenmedico->save();

            \App\ExamenMedicoDetalle::where('ExamenMedico_idExamenMedico',$id)->delete();

            $contadorDetalle = count($request['TipoExamenMedico_idTipoExamenMedico']);
            for($i = 0; $i < $contadorDetalle; $i++)
            {
                \App\ExamenMedicoDetalle::create([
                'ExamenMedico_idExamenMedico' => $id,
                'TipoExamenMedico_idTipoExamenMedico' => $request['TipoExamenMedico_idTipoExamenMedico'][$i],
                'resultadoExamenMedicoDetalle' => $request['resultadoExamenMedicoDetalle'][$i],
                'observacionExamenMedicoDetalle' => $request['observacionExamenMedicoDetalle'][$i]
               ]);
                
            }

            return redirect('/examenmedico');
        }    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    

    public function destroy($id)
    {

        \App\ExamenMedico::destroy($id);
        return redirect('/examenmedico');
    }
}