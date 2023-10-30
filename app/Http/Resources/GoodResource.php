<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodResource extends JsonResource
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
            'IMEI' => $this->IMEI,
            'provider' => $this?->provider_id,
            'barcode' => $this->type?->barcode,
            'name' => $this->type?->name,
            'price' => $this->price ? $this->price : 0
        ];
    }
}
