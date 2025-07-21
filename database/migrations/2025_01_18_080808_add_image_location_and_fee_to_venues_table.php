<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageLocationAndFeeToVenuesTable extends Migration
{
    public function up()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->string('image_location')->nullable(); // Add image_location column
            $table->decimal('fee', 10, 2); // Add fee column
        });
    }

    public function down()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn(['image_location', 'fee']);
        });
    }
}
