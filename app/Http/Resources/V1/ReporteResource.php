<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class ReporteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
          
            'tipo_reporte' => [
                'tipo_reporte_id' => $this->tipo_reporte_id,
                'tipo_reporte' => $this->tipo_reporte
            ],
            
            'vehiculo' => [
                'placa_id' => $this->placa_id,
                'placa' => $this->placa
            ],
            
            'periodos' => [
                'periodo_id' => $this->periodo_id,
                'periodo' => $this->periodo
            ],
            'sedes' => [
                'sede_id' => $this->sede_id,
                'nombre' => $this->descripcion
            ],
            'usuarios' => [
                'user_id' => $this->user_id,
                'name' => $this->name,
                'email' => $this->email
              ]
           
        ];
    }
}
