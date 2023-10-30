<?php

namespace App\Http\Resources\Consultant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RealizationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'doc_number' => $this->doc_number,
            'date' => $this->created_at->format('d-m-Y')
        ];
    }
}
