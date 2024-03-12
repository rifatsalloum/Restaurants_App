<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $new_price = $this->getNewPriceAttribute();
        $ordered_price = (!$request->new_price)? $this->getOrderedPriceAttribute() : null;

        return [
            "uuid" => $this->uuid,
            "type" => $this->type,
            "status" => $this->status,
            "items" => OrderItemResource::collection($this->items),
            "overall_price" => ((!$request->new_price)?  $ordered_price : $new_price) . "$",
            "price_change" => (!$request->new_price)? $new_price !== $ordered_price : false,
            "created_at" => ($item = $this->item)? $item->created_at->diffForHumans() : $this->created_at->diffForHumans(),
        ];
    }
}
