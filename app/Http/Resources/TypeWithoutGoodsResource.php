<?php

namespace App\Http\Resources;

use App\Models\Good;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TypeWithoutGoodsResource extends JsonResource
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
            'barcode' => $this->barcode,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'amount' => $this->goods->count(),
        ];
    }
}
