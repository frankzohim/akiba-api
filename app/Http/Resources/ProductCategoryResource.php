<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductCategory;

class ProductCategoryResource extends JsonResource
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
            'parent' => ProductCategory::find($this->parent_id),
            'name' => $this->name,
            'slug' => $this->slug,
            'state' => $this->state,
            'childreen' => ProductCategoryResource::collection(ProductCategory::where('parent_id', $this->id)->get())
        ];
    }
}
