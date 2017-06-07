<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'In_IdeFactura';

    protected $fillable = ['Da_Fecha_Factura', 'Nv_Nota', 'cliente_In_Idcliente'];

    public $timestamps = false;

    public function FacturaDetalle()
    {
    	return $this->hasMany('App\FacturaDetalle','In_IdeFactura');
    }

    
}