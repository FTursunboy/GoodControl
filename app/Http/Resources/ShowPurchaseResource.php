<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowPurchaseResource extends JsonResource
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
            'number' => 21312,
            'provider' => $this->provider?->name,
            'barcode' => $this->type?->barcode,
            'goods' => GoodResource::collection($this->type?->goods)
        ];
    }
}
