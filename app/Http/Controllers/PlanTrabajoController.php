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
        //
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
