<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Tercero extends Model
{
    protected $table = 'tercero';
    protected $primaryKey = 'idTercero';
    protected $fillable = ['TipoIdentificacion_idTipoIdentificacion','documentoTercero','nombre1Tercero','nombre2Tercero','apellido1Tercero','apellido2Tercero','nombreCompletoTercero','fechaCreacionTercero','estadoTercero','imagenTercero','tipoTercero','direccionTercero','Ciudad_idCiudad','telefonoTercero','faxTercero','movil1Tercero','movil2Tercero','sexoTercero','correoElectronicoTercero','paginaWebTercero','Cargo_idCargo','Compania_idCompania', 'Zona_idZona', 'SectorEmpresa_idSectorEmpresa', 'Tercero_idEmpleadorContratista','CentroCosto_idCentroCosto'];

    public $timestamps = false;
    
    public function terceroContactos()
    {
        return $this->hasMany('App\TerceroContacto','Tercero_idTercero');
    }
    
    public function terceroProductos()
    {
        return $this->hasMany('App\TerceroProducto','Tercero_idTercero');
    }

    public function terceroExamenMedicos()
    {
        return $this->hasMany('App\TerceroExamenMedico','Tercero_idTercero');
    }

    public function terceroArchivos()
    {
        return $this->hasMany('App\TerceroArchivo','Tercero_idTercero');
    }

    public function terceroInformaciones()
    {
        return $this->hasOne('App\TerceroInformacion','Tercero_idTercero');
    }

    public function presupuesto()
    {
        return $this->hasMany('App\Presupuesto','Tercero_idTercero');
    }

     public function Entrevista()
     {
         return $this->hasMany('App\Entrevista','Tercero_idTercero');
     }
      public function EvaluacionDesempenio()
     {
         return $this->hasMany('App\EvaluacionDesempenio','Tercero_idTercero');
     }
      public function Cargo()
     {
         return $this->hasMany('App\Cargo','Cargo_idCargo');
     }
       public function CentroCosto()
     {
         return $this->hasMany('App\CentroCosto','CentroCosto_idCentroCosto');
     }
}