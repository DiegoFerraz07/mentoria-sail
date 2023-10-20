<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $message = '';
        if(!$this['success']) {
            $message = 'Erro ao tentar salvar';
        }
        return array(
            'success' => $this['success'],
            'message' => $message
        );
    }
}
