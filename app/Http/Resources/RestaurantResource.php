<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "uuid" => $this->uuid,
            "name" => $this->name,
            "cuisine" => $this->cuisine_type,
            "address" => $this->address,
            "email" => $this->email,
            "phone" => $this->phone,
            "rate" => $this->getAverageRatingAttribute(),
            "menu" => RestaurantItemResource::collection($this->menus),
        ];
    }
}
