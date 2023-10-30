<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodsByBarcodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'barcode' => $this->barcode,
            'name' => $this->name,
            'count' => $this->goods()->count(),
            'goods' => GoodResource::collection($this->goods)
        ];
    }
}
