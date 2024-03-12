<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","order_id","restaurant_item_id","price","number"
    ];
    protected $casts = [
        "uuid" => "string",
        "price" => "double",
        "number" => "integer",
    ];
    protected $hidden = [
        "order_id","restaurant_item_id",
    ];
    public function orderedItem() : object
    {
        return $this->belongsTo(RestaurantItem::class,"restaurant_item_id");
    }
}
