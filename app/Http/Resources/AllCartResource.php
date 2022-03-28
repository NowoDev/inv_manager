<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllCartResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'inventory' => $this->inventory,
            'quantity' => $this->quantity,
        ];
    }

    public function with($request)
    {
        return [
            'status_code' => 200,
            'status' => 'Success',
        ];
    }
}
