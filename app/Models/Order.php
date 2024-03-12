<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","user_id","type","status"
    ];
    protected $casts = [
        "uuid" => "string",
        "type" => "string",
        "status" => "string",
    ];
    protected $hidden = [
        "user_id",
    ];
    protected $appends = [
        "new-price",
        "ordered-price"
    ];
    public function items() : object
    {
        return $this->hasMany(OrderItem::class);
    }
    public function item() : object
    {
        return $this->hasOne(OrderItem::class);
    }
    public function getNewPriceAttribute() : float
    {
        return array_sum(
            $this->items->map(fn($item) => $item->orderedItem->price * $item->number)->toArray()
        );
    }
    public function getOrderedPriceAttribute() : float
    {
        return array_sum(
            $this->items->map(fn($item) => $item->price * $item->number)->toArray()
        );
    }
}
