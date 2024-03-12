<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("order_id");
            $table->unsignedBigInteger("restaurant_item_id");
            $table->float("price");
            $table->integer("number");
            $table->foreign("order_id")->references("id")->on("orders")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("restaurant_item_id")->references("id")->on("restaurant_items");
            $table->unique(["order_id","restaurant_item_id"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
