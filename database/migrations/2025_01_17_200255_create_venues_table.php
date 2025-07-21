<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Name of the venue
            $table->text('description')->nullable(); // Description of the venue
            $table->string('location'); // Location of the venue
            $table->integer('capacity'); // Capacity of the venue
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('venues');
    }
}