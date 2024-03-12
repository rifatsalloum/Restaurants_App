<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","restaurant_id","user_id","rate","comment"
    ];
    protected $casts = [
        "uuid" => "string",
        "rate" => "integer",
        "comment" => "string",
    ];
    protected $hidden = [
        "restaurant_id","user_id"
    ];
}
