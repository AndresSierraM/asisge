<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PlanEmergenciaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {    
        // Campos multiregistro Limites geograficos
         $planemergenciaSede = count($this->get('sedePlanEmergenciaLimite'));
         $planemergenciaNorte = count($this->get('nortePlanEmergenciaLimite'));
         $planemergenciaSur = count($this->get('surPlanEmergenciaLimite'));
         $planemergenciaOriente = count($this->get('orientePlanEmergenciaLimite'));
         $planemergenciaOccidente = count($this->get('occidentePlanEmergenciaLimite'));
          // Campos multiregistro Inventario
         $planemergenciaSedeInventario = count($this->get('sedePlanEmergenciaInventario'));
         $planemergenciaRecursoInventario = count($this->get('recursoPlanEmergenciaInventario'));
         $planemergenciaCantidadInventario = count($this->get('cantidadPlanEmergenciaInventario'));
         $planemergenciaUbicacionInventario = count($this->get('ubicacionPlanEmergenciaInventario'));
         $planemergenciaObservacionInventario = count($this->get('observacionPlanEmergenciaInventario'));
          // Campos multiregistro Comite
         $planemergenciaComite = count($this->get('comitePlanEmergenciaComite'));
         $planemergenciaIntegrantes = count($this->get('integrantesPlanEmergenciaComite'));
           // Campos multiregistro Nivel
         $planemergenciaNivelCargo = count($this->get('cargoPlanEmergenciaNivel'));


        $validacion = array(
            "nombrePlanEmergencia" => "required",
            "fechaElaboracionPlanEmergencia" => "required",
            "CentroCosto_idCentroCosto" => "required",
            "Tercero_idRepresentanteLegal" => "required"
        );


// For Multiregistro limietes geograficos
        for($i = 0; $i < $planemergenciaSede; $i++)
        {
            if(trim($this->get('sedePlanEmergenciaLimite')[$i]) == '')
            {    
                $validacion['sedePlanEmergenciaLimite'.$i] =  'required';
            }
        }

        for($i = 0; $i < $planemergenciaNorte; $i++)
        {
            if(trim($this->get('nortePlanEmergenciaLimite')[$i]) == '')
            {    
                $validacion['nortePlanEmergenciaLimite'.$i] =  'required';
            }
        }
        for($i = 0; $i < $planemergenciaSur; $i++)
        {
            if(trim($this->get('surPlanEmergenciaLimite')[$i]) == '')
            {    
                $validacion['surPlanEmergenciaLimite'.$i] =  'required';
            }
        }
        for($i = 0; $i < $planemergenciaOriente; $i++)
        {
            if(trim($this->get('orientePlanEmergenciaLimite')[$i]) == '')
            {    
                $validacion['orientePlanEmergenciaLimite'.$i] =  'required';
            }
        }

        for($i = 0; $i < $planemergenciaOccidente; $i++)
        {
            if(trim($this->get('occidentePlanEmergenciaLimite')[$i]) == '')
            {    
                $validacion['occidentePlanEmergenciaLimite'.$i] =  'required';
            }
        }
        // Cierra FOR LIMITES

        // For Multiregistro Inventario
        for($i = 0; $i < $planemergenciaSedeInventario ; $i++)
        {
            if(trim($this->get('sedePlanEmergenciaInventario')[$i]) == '')
            {    
                $validacion['sedePlanEmergenciaInventario'.$i] =  'required';
            }
        }

        for($i = 0; $i < $planemergenciaRecursoInventario ; $i++)
        {
            if(trim($this->get('recursoPlanEmergenciaInventario')[$i]) == '')
            {    
                $validacion['recursoPlanEmergenciaInventario'.$i] =  'required';
            }
        }
        for($i = 0; $i < $planemergenciaCantidadInventario ; $i++)
        {
            if(trim($this->get('cantidadPlanEmergenciaInventario')[$i]) == '')
            {    
                $validacion['cantidadPlanEmergenciaInventario'.$i] =  'required';
            }
        }
        for($i = 0; $i < $planemergenciaUbicacionInventario ; $i++)
        {
            if(trim($this->get('ubicacionPlanEmergenciaInventario')[$i]) == '')
            {    
                $validacion['ubicacionPlanEmergenciaInventario'.$i] =  'required';
            }
        }
        for($i = 0; $i < $planemergenciaObservacionInventario ; $i++)
        {
            if(trim($this->get('observacionPlanEmergenciaInventario')[$i]) == '')
            {    
                $validacion['observacionPlanEmergenciaInventario'.$i] =  'required';
            }
        }        
        // Cierra FOR INVENTARIO

        // For Multiregistro Comie
        for($i = 0; $i < $planemergenciaComite  ; $i++)
        {
            if(trim($this->get('comitePlanEmergenciaComite')[$i]) == '')
            {    
                $validacion['comitePlanEmergenciaComite'.$i] =  'required';
            }
        }

        for($i = 0; $i < $planemergenciaIntegrantes  ; $i++)
        {
            if(trim($this->get('integrantesPlanEmergenciaComite')[$i]) == '')
            {    
                $validacion['integrantesPlanEmergenciaComite'.$i] =  'required';
            }
        }
      
        // Cierra FOR COMITE
          // For Multiregistro nivel
        for($i = 0; $i < $planemergenciaNivelCargo; $i++)
        {
            if(trim($this->get('cargoPlanEmergenciaNivel')[$i]) == '')
            {    
                $validacion['cargoPlanEmergenciaNivel'.$i] =  'required';
            }
        }
        // Cierra FOR nivel
        return $validacion;
        
    }

    public function messages()
    {
       // Campos multiregistro Limites geograficos
         $planemergenciaSede = count($this->get('sedePlanEmergenciaLimite'));
         $planemergenciaNorte = count($this->get('nortePlanEmergenciaLimite'));
         $planemergenciaSur = count($this->get('surPlanEmergenciaLimite'));
         $planemergenciaOriente = count($this->get('orientePlanEmergenciaLimite'));
         $planemergenciaOccidente = count($this->get('occidentePlanEmergenciaLimite'));
         // Campos multiregistro Inventario
         $planemergenciaSedeInventario = count($this->get('sedePlanEmergenciaInventario'));
         $planemergenciaRecursoInventario = count($this->get('recursoPlanEmergenciaInventario'));
         $planemergenciaCantidadInventario = count($this->get('cantidadPlanEmergenciaInventario'));
         $planemergenciaUbicacionInventario = count($this->get('ubicacionPlanEmergenciaInventario'));
         $planemergenciaObservacionInventario = count($this->get('observacionPlanEmergenciaInventario'));
         // Campos multiregistro Comite
         $planemergenciaComite = count($this->get('comitePlanEmergenciaComite'));
         $planemergenciaIntegrantes = count($this->get('integrantesPlanEmergenciaComite'));
          // Campos multiregistro Nivel
         $planemergenciaNivelCargo = count($this->get('cargoPlanEmergenciaNivel'));



        $mensajes = array();
        $mensajes["nombrePlanEmergencia.required"] = "[Encabezado] Debe ingresar el nombre del plan de emergencia";
        $mensajes["fechaElaboracionPlanEmergencia.required"] = "[Encabezado] ingresar la fecha de Elaboración";
        $mensajes["CentroCosto_idCentroCosto.required"] = "[Encabezado] Debe Seleccionar el centro de costo";
        $mensajes["Tercero_idRepresentanteLegal.required"] = "[Encabezado] Debe seleccionar el Responsable";

        
        // --FOR PARA MULTIREGISTRO LIMITES
         for($i = 0; $i < $planemergenciaSede; $i++)
        {
            if(trim($this->get('sedePlanEmergenciaLimite')[$i]) == '' )
            {    
                $mensajes["sedePlanEmergenciaLimite".$i.".required"] = "[Detalle Límites geográficos] Debe ingresar la Sede en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaNorte; $i++)
        {
            if(trim($this->get('nortePlanEmergenciaLimite')[$i]) == '' )
            {    
                $mensajes["nortePlanEmergenciaLimite".$i.".required"] = "[Detalle Límites geográficos] Debe ingresar el campo norte en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaSur; $i++)
        {
            if(trim($this->get('surPlanEmergenciaLimite')[$i]) == '' )
            {    
                $mensajes["surPlanEmergenciaLimite".$i.".required"] = "[Detalle Límites geográficos] Debe ingresar el campo sur en la línea".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaOriente; $i++)
        {
            if(trim($this->get('orientePlanEmergenciaLimite')[$i]) == '' )
            {    
                $mensajes["orientePlanEmergenciaLimite".$i.".required"] = "[Detalle Límites geográficos] Debe ingresar el campo oriente en la línea ".($i+1);
            }           
        }
           for($i = 0; $i < $planemergenciaOccidente; $i++)
        {
            if(trim($this->get('occidentePlanEmergenciaLimite')[$i]) == '' )
            {    
                $mensajes["occidentePlanEmergenciaLimite".$i.".required"] = "[Detalle Límites geográficos] Debe ingresar el campo occidente en la línea ".($i+1);
            }           
        }
        // CIERRRE MULTIREGISTRO LIMITE

          // --FOR PARA MULTIREGISTRO LIMITES
         for($i = 0; $i < $planemergenciaSedeInventario ; $i++)
        {
            if(trim($this->get('sedePlanEmergenciaInventario')[$i]) == '' )
            {    
                $mensajes["sedePlanEmergenciaInventario".$i.".required"] = "[Detalle inventario de recursos físicos] Debe ingresar la Sede en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaRecursoInventario; $i++)
        {
            if(trim($this->get('recursoPlanEmergenciaInventario')[$i]) == '' )
            {    
                $mensajes["recursoPlanEmergenciaInventario".$i.".required"] = "[Detalle inventario de recursos físicos] Debe ingresar el recurso en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaCantidadInventario; $i++)
        {
            if(trim($this->get('cantidadPlanEmergenciaInventario')[$i]) == '' )
            {    
                $mensajes["cantidadPlanEmergenciaInventario".$i.".required"] = "[Detalle inventario de recursos físicos] Debe ingresar la cantidad en la línea".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaUbicacionInventario; $i++)
        {
            if(trim($this->get('ubicacionPlanEmergenciaInventario')[$i]) == '' )
            {    
                $mensajes["ubicacionPlanEmergenciaInventario".$i.".required"] = "[Detalle inventario de recursos físicos] Debe ingresar la ubicación en la línea ".($i+1);
            }           
        }
           for($i = 0; $i < $planemergenciaObservacionInventario; $i++)
        {
            if(trim($this->get('observacionPlanEmergenciaInventario')[$i]) == '' )
            {    
                $mensajes["observacionPlanEmergenciaInventario".$i.".required"] = "[Detalle inventario de recursos físicos] Debe ingresar las observaciones en la línea ".($i+1);
            }           
        }
          // CIERRRE MULTIREGISTRO Inventario

                // --FOR PARA MULTIREGISTRO COMITE
         for($i = 0; $i < $planemergenciaComite  ; $i++)
        {
            if(trim($this->get('comitePlanEmergenciaComite')[$i]) == '' )
            {    
                $mensajes["comitePlanEmergenciaComite".$i.".required"] = "[Detalle Comités y grupos que apoyan situaciones de emergencia] Debe ingresar el comité o grupo en la línea ".($i+1);
            }           
        }
         for($i = 0; $i < $planemergenciaIntegrantes ; $i++)
        {
            if(trim($this->get('integrantesPlanEmergenciaComite')[$i]) == '' )
            {    
                $mensajes["integrantesPlanEmergenciaComite".$i.".required"] = "[Detalle Comités y grupos que apoyan situaciones de emergencia] Debe ingresar los integrantes en la línea ".($i+1);
            }           
        }
          // CIERRRE MULTIREGISTRO COMITE
              // --FOR PARA MULTIREGISTRO Nivel
         for($i = 0; $i < $planemergenciaNivelCargo ; $i++)
        {
            if(trim($this->get('cargoPlanEmergenciaNivel')[$i]) == '' )
            {    
                $mensajes["cargoPlanEmergenciaNivel".$i.".required"] = "[Detalle niveles de actuación] Debe ingresar el cargo en la línea ".($i+1);
            }           
        }
          // CIERRRE MULTIREGISTRO Nivel
        return $mensajes;

    }


}
