<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id' => (string)$this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'sku' => $this->sku,
            'reference' => $this->reference,
            'summary' => $this->summary,
            'description' => $this->description,
            'price' => $this->price,
            'sale_quantity' => $this->sale_quantity,
            'stock_quantity' => $this->stock_quantity,
            'video' => $this->video,
            'state' => $this->state,
            'category' => $this->productCategory,
            'brand' => $this->brand,
            'images' => $this->images,
            'date' => $this->created_at
        ];
    }
}
