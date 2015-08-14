<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tercero extends Model
{
    protected $table = 'tercero';
    protected $primaryKey = 'idTercero';

    protected $fillable = ['TipoIdentificacion_idTipoIdentificacion','documentoTercero','nombre1Tercero','nombre2Tercero','apellido1Tercero','apellido2Tercero','nombreCompletoTercero','fechaCreacionTercero','estadoTercero','imagenTercero','tipoTercero','direccionTercero','Ciudad_idCiudad','telefonoTercero','faxTercero','movil1Tercero','movil2Tercero','sexoTercero','fechaNacimientoTercero','correoElectronicoTercero','paginaWebTercero','Cargo_idCargo','Compania_idCompania'];

    public $timestamps = false;
}
