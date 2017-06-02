<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccidenteArchivo extends Model
{
    protected $table = 'accidentearchivo';
    protected $primaryKey = 'idAccidenteArchivo';	

    protected $fillable = ['rutaAccidenteArchivo','Accidente_idAccidente'];

    public $timestamps = false;

    
}
