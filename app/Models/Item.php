<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","type",
    ];
    protected $casts = [
        "uuid" => "string",
        "name" => "string",
        "type" => "string",
    ];

}
