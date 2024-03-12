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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger("restaurant_id");
            $table->unsignedBigInteger("user_id");
            $table->integer("rate");
            $table->string("comment");
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("restaurant_id")->references("id")->on("restaurants")->onDelete("cascade")->onUpdate("cascade");
            $table->unique(["restaurant_id","user_id"]);
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
        Schema::dropIfExists('ratings');
    }
};
