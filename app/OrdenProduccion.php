<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenProduccion extends Model
{
    protected $table = 'ordenproduccion';
    protected $primaryKey = 'idOrdenProduccion';

    protected $fillable = ['numeroOrdenProduccion', 'fechaElaboracionOrdenProduccion', 'Tercero_idCliente', 'numeroPedidoOrdenProduccion', 'prioridadOrdenProduccion', 'fechaMaximaEntregaOrdenProduccion', 'FichaTecnica_idFichaTecnica', 'especificacionOrdenProduccion', 'cantidadOrdenProduccion', 'estadoOrdenProduccion', 'observacionOrdenProduccion','Compania_idCompania'];

    public $timestamps = false;

    public function OrdenProduccionProceso()
    {
    	return $this->hasMany('App\OrdenProduccionProceso','OrdenProduccion_idOrdenProduccion');
    }

   public function OrdenProduccionMaterial()
    {
    	return $this->hasMany('App\OrdenProduccionMaterial','OrdenProduccion_idOrdenProduccion');
    }
}