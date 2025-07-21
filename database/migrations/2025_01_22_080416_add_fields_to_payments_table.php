<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('refno')->nullable(); // Add refno
            $table->string('reason')->nullable(); // Add reason
            $table->string('billcode')->nullable(); // Add billcode
        });
    }
    
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['refno', 'reason', 'billcode']);
        });
    }
};
