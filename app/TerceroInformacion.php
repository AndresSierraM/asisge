<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TerceroInformacion extends Model
{
    protected $table = 'terceroinformacion';
    protected $primaryKey = 'idTerceroInformacion';

    protected $fillable = ['Tercero_idTercero', 'fechaNacimientoTerceroInformacion', 'fechaIngresoTerceroInformacion', 'fechaRetiroTerceroInformacion', 'tipoContratoTerceroInformacion', 'aniosExperienciaTerceroInformacion', 'educacionTerceroInformacion', 'experienciaTerceroInformacion', 'formacionTerceroInformacion', 'estadoCivilTerceroInformacion', 'numeroHijosTerceroInformacion', 'composicionFamiliarTerceroInformacion', 'personasACargoTerceroInformacion', 'estratoSocialTerceroInformacion', 'tipoViviendaTerceroInformacion', 'tipoTransporteTerceroInformacion', 'HobbyTerceroInformacion', 'actividadFisicaTerceroInformacion', 'consumeLicorTerceroInformacion', 'FrecuenciaMedicion_idConsumeLicor', 'consumeCigarrilloTerceroInformacion'];

    public $timestamps = false;

    public function tercero()
    {
		return $this->hasOne('App\Tercero','idTercero');
    }
}
