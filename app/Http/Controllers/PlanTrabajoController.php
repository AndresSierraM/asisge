<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
class PlanTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // -------------------------------------------
        // A C C I D E N T E S / I N C I D E N T E S
        // -------------------------------------------
        $accidente = DB::select(
            'SELECT nombreCompletoTercero,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 1, 1 , 0)) as EneroT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 1, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as EneroC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 2, 1 , 0)) as FebreroT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 2, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as FebreroC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 3, 1 , 0)) as MarzoT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 3, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as MarzoC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 4, 1 , 0)) as AbrilT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 4, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as AbrilC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 5, 1 , 0)) as MayoT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 5, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as MayoC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 6, 1 , 0)) as JunioT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 6, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as JunioC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 7, 1 , 0)) as JulioT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 7, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as JulioC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 8, 1 , 0)) as AgostoT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 8, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as AgostoC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 9, 1 , 0)) as SeptiembreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 9, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as SeptiembreC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 10, 1 , 0)) as OctubreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 10, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as OctubreC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 11, 1 , 0)) as NoviembreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 11, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as NoviembreC,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 12, 1 , 0)) as DiciembreT,
                SUM(IF(MONTH(fechaElaboracionAusentismo) = 12, IF(Acc.idAccidente IS NULL, 0, 1), 0)) as DiciembreC
            FROM ausentismo Aus
            left join accidente Acc
            on Aus.idAusentismo = Acc.Ausentismo_idAusentismo
            left join tercero T
            on Aus.Tercero_idTercero = T.idTercero
            Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%") 
            group by Aus.Tercero_idTercero;');
            
        return view('plantrabajo', compact('accidente'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $accidente = DB::table('accidente as a')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as enero
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 1
                                            group by a.Tercero_idEmpleado) as uno'),'a.Tercero_idEmpleado','=','uno.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as febrero
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 2
                                            group by a.Tercero_idEmpleado) as dos'),'a.Tercero_idEmpleado','=','dos.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as marzo
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 3
                                            group by a.Tercero_idEmpleado) as tres'),'a.Tercero_idEmpleado','=','tres.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as abril
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 4
                                            group by a.Tercero_idEmpleado) as cuatro'),'a.Tercero_idEmpleado','=','cuatro.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as mayo
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 5
                                            group by a.Tercero_idEmpleado) as cinco'),'a.Tercero_idEmpleado','=','cinco.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as junio
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 6
                                            group by a.Tercero_idEmpleado) as seis'),'a.Tercero_idEmpleado','=','seis.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as julio
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 7
                                            group by a.Tercero_idEmpleado) as siete'),'a.Tercero_idEmpleado','=','siete.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as agosto
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 8
                                            group by a.Tercero_idEmpleado) as ocho'),'a.Tercero_idEmpleado','=','ocho.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as septiembre
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 9
                                            group by a.Tercero_idEmpleado) as nueve'),'a.Tercero_idEmpleado','=','nueve.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as octubre
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 10
                                            group by a.Tercero_idEmpleado) as diez'),'a.Tercero_idEmpleado','=','diez.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as noviembre
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 11
                                            group by a.Tercero_idEmpleado) as once'),'a.Tercero_idEmpleado','=','once.Tercero_idEmpleado')
                        ->leftjoin(DB::raw('(select a.Tercero_idEmpleado, count(a.idAccidente) as diciembre
                                            from accidente a
                                            where MONTH(a.fechaOcurrenciaAccidente) = 12
                                            group by a.Tercero_idEmpleado) as doce'),'a.Tercero_idEmpleado','=','doce.Tercero_idEmpleado')
                        ->leftjoin('tercero as t','a.Tercero_idEmpleado','=','t.idTercero')
                        ->select(DB::raw('t.nombreCompletoTercero, enero, febrero, marzo, abril, mayo, junio, julio, agosto, septiembre, octubre, noviembre, diciembre'))
                        ->groupBy('a.Tercero_idEmpleado')
                        ->get();


        return view('plantrabajo', compact('accidente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
