<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrizLegal extends Model
{
    protected $table = 'matrizlegal';
    protected $primaryKey = 'idMatrizLegal';

    protected $fillable = ['nombreMatrizLegal','fechaElaboracionMatrizLegal','origenMatrizLegal','Users_id'];

    public $timestamps = false;

    public function matrizLegalDetalles()
    {
		return $this->hasMany('App\MatrizLegalDetalle','MatrizLegal_idMatrizLegal');
    }
}
