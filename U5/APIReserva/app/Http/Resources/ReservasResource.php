<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservasResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'empleado' => $this->empleado,
            'fecha_inicio' => $this->fechaI,
            'fecha_fin' => $this->fechaF,
            'recurso' => [
                'nombre' => $this->recurso->nombre,
                'tipo' => $this->recurso->tipo,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
