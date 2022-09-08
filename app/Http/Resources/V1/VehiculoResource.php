<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class VehiculoResource extends JsonResource
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
            'placa' => $this->placa,
            'observacion' => $this->observacion,
            'tipo_vehiculo' => [
                'tipo_vehiculo_id' => $this->tipo_vehiculo_id,
                'descripcion' => $this->descripcion
            ],
            'usuarios' => [
                'user_id' => $this->user_id,
                'name' => $this->name,
                'email' => $this->email
              ]
           
        ];
    }
}
