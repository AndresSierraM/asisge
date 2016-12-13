@extends('layouts.formato')

@section('contenido')
	{!!Form::model($plantrabajo)!!}
	<?php

	function consultarAccidentes()
	{
		// -------------------------------------------
		// A C C I D E N T E S / I N C I D E N T E S
		// -------------------------------------------
		$datos = DB::select(
		    'SELECT idAccidente as idTarea, nombreCompletoTercero as descripcionTarea,
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
		    Where (tipoAusentismo like "%Accidente%" or tipoAusentismo like "%Incidente%")  and 
		        Aus.Compania_idCompania = '.$idCompania .' 
		    group by Aus.Tercero_idTercero;');
	}

	function consultarActas()
	{
		// -------------------------------------------
		//  G R U P O S   D E   A P O Y O
		// -------------------------------------------
		$datos = DB::select(
		    'SELECT idActaGrupoApoyo as idTarea, nombreGrupoApoyo as descripcionTarea, 
		        SUM(IF((MOD(1,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as EneroT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 1, 1, 0 )) as EneroC,
		        SUM(IF((MOD(2,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as FebreroT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 2, 1, 0 )) as FebreroC,
		        SUM(IF((MOD(3,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MarzoT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 3, 1, 0 )) as MarzoC,
		        SUM(IF((MOD(4,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AbrilT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 4, 1, 0 )) as AbrilC,
		        SUM(IF((MOD(5,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as MayoT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 5, 1, 0 )) as MayoC,
		        SUM(IF((MOD(6,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JunioT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 6, 1, 0 )) as JunioC,
		        SUM(IF((MOD(7,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as JulioT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 7, 1, 0 )) as JulioC,
		        SUM(IF((MOD(8,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as AgostoT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 8, 1, 0 )) as AgostoC,
		        SUM(IF((MOD(9,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as SeptiembreT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 9, 1, 0 )) as SeptiembreC,
		        SUM(IF((MOD(10,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as OctubreT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 10, 1, 0 )) as OctubreC,
		        SUM(IF((MOD(11,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as NoviembreT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 11, 1, 0 )) as NoviembreC,
		        SUM(IF((MOD(12,valorFrecuenciaMedicion) = 0 and unidadFrecuenciaMedicion IN ("Meses")), 1 , 0)) as DiciembreT,
		        SUM(IF(MONTH(fechaActaGrupoApoyo) = 12, 1, 0 )) as DiciembreC
		    FROM grupoapoyo GA
		    left join frecuenciamedicion FM
		    on GA.FrecuenciaMedicion_idFrecuenciaMedicion = FM.idFrecuenciaMedicion
		    left join actagrupoapoyo AGA
		    on GA.idGrupoApoyo = AGA.GrupoApoyo_idGrupoApoyo
		    Where GA.Compania_idCompania = '.$idCompania .' 
		    group by idGrupoApoyo');
	}

	$plan = array();
  		// por facilidad de manejo convierto el stdclass a tipo array con un cast (array)
       for ($i = 0, $c = count($plantrabajo); $i < $c; ++$i) 
       {
          $plan[$i] = (array) $plantrabajo[$i];
       }

	?>
	{!!Form::close()!!}
@stop