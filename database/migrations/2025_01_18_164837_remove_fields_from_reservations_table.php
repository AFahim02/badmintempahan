<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFieldsFromReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['location', 'capacity', 'fee', 'description', 'image_location']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('location')->nullable();
            $table->integer('capacity')->nullable();
            $table->decimal('fee', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image_location')->nullable();
        });
    }
}