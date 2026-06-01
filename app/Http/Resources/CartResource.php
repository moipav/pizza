<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'items' => CartItemResource::collection($this->whenLoaded('items')) ?? collect(),
            'total_quantity' => $this->items->sum('quantity'),
            'total_amount' => $this->items->sum(fn ($item) => $item->price_per_unit * $item->quantity),
        ];
    }
}
