<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListaChequeoDetalle extends Model
{
	protected $table = 'listachequeodetalle';
    protected $primaryKey = 'idListaChequeoDetalle';

    protected $fillable = ['ListaChequeo_idListaChequeo', 'PreguntaListaChequeo_idPreguntaListaChequeo','Tercero_idTercero','respuestaListaChequeoDetalle','conformeListaChequeoDetalle','hallazgoListaChequeoDetalle','observacionListaChequeoDetalle'];

    public $timestamps = false;

    function planAuditoria()
    {
		return $this->hasOne('App\ListaChequeo','idListaChequeo');
    }

}
