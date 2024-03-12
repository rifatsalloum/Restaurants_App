<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(!$request->new_price)
          $request["price"] = $this->price;

        return [
            "uuid" => $this->uuid,
            "ordered_item" => RestaurantItemResource::make($this->orderedItem),
            "number" => $this->number
        ];
    }
}
