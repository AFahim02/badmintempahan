<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('capacity')->nullable();
            $table->decimal('fee', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image_location')->nullable();
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['capacity', 'fee', 'description', 'image_location']);
        });
    }
}