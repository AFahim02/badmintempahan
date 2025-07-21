<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // If you need to change the default value
            $table->string('payment_status')->default('pending')->change();
        });
    }
    
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            // Revert to the previous state if necessary
            $table->string('payment_status')->default(null)->change();
        });
    }
};
