<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PresupuestoDetalle extends Model
{
    protected $table = 'presupuestodetalle';
    protected $primaryKey = 'idPresupuestoDetalle';

    protected $fillable = [
					    'Tercero_idVendedor', 
					    'valorLineaNegocio',
                        'Presupuesto_idPresupuesto'
					    ];

    public $timestamps = false;

    public function presupuesto()
    {
    	return $this->hasOne('App\Presupuesto','idPresupuesto');
    }
}