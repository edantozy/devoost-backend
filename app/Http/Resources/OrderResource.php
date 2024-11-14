<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'client' => new ClientResource($this->whenLoaded('client')),
            'products' => OrderItemResource::collection($this->whenLoaded('items')),
            'total' => $this->total,
            'status' => $this->status,
            'created_at' => $this->created_at ? $this->created_at->format('c') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('c') : null,
        ];
    }
}
