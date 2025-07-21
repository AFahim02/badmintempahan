<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->decimal('fee', 10, 2)->nullable(); // Add the fee column
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('fee'); // Drop the fee column
        });
    }
};
