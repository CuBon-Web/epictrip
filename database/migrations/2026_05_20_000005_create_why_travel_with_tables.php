<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhyTravelWithTables extends Migration
{
    public function up()
    {
        Schema::create('why_travel_withs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('image', 500)->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('why_travel_withs');
    }
}
