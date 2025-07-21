<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->string('status')->default('available'); // Add the status column
        });
    }
    
    public function down()
    {
        Schema::table('venues', function (Blueprint $table) {
            $table->dropColumn('status'); // Remove the status column
        });
    }
};
