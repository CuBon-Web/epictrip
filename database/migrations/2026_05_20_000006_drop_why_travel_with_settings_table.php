<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropWhyTravelWithSettingsTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('why_travel_with_settings');
    }

    public function down()
    {
        Schema::create('why_travel_with_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('section_title')->nullable();
            $table->text('section_description')->nullable();
            $table->timestamps();
        });
    }
}
