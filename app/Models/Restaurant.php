<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","cuisine_type","address","email","phone"
    ];

    protected $casts = [
        "uuid" => "string",
        "name" => "string",
        "cuisine_type" => "string",
        "address" => "string",
        "email" => "string",
        "phone" => "string",
    ];
    protected $appends = [
        "average-rating"
    ];
    public function menus() : object
    {
        return $this->hasMany(RestaurantItem::class);
    }
    public function menuItems() : object
    {
        return $this->belongsToMany(Item::class,"restaurant_items")->withPivot(["id","price"]);
    }
    public function ratings() : object
    {
        return $this->hasMany(Rating::class);
    }
    public function getAverageRatingAttribute() : float
    {
        $rates = $this->ratings->map(fn($rating) => $rating->rate)->toArray();

        $count = count($rates);

        return ($count)? array_sum($rates)/$count : 0;
    }
}
