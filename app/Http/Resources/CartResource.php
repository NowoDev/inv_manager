<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * // * @property mixed $inventory
 * @property mixed $quantity
 * @property mixed $inventory_id
 * @property mixed $user_id
 */
class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
//            'inventory_id' => InventoryResource::collection($this->inventory->id),
            'inventory_id' => $this->inventory_id,
            'quantity' => $this->quantity,
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'OK',
        ];
    }
}
