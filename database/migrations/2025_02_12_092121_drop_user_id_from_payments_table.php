<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUserIdFromPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('user_id'); // Drop the user_id column
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Restore the user_id column
        });
    }
}