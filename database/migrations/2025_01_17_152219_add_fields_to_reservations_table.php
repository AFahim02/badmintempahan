<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->time('start_time')->after('reservation_date'); // Add start_time column
            $table->time('end_time')->after('start_time'); // Add end_time column
            $table->string('contact_number')->after('end_time'); // Add contact_number column
            $table->string('payment_status')->default('Pending')->after('contact_number'); // Add payment_status column
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time', 'contact_number', 'payment_status']); // Drop the columns if rolling back
        });
    }
}