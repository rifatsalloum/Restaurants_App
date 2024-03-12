<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantItem extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","restaurant_id","item_id","price"
    ];
    protected $casts = [
        "uuid" => "string",
        "price" => "double",
    ];
    protected $hidden = [
        "restaurant_id","item_id",
    ];
    public function item() : object
    {
        return $this->belongsTo(Item::class);
    }
}
