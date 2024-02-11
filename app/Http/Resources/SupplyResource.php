<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $saveAndMessage = $this['saveAndMessage'];
        return array(
            'success' => $saveAndMessage['success'],
            'message' => $saveAndMessage['message']
        );
    }
}
