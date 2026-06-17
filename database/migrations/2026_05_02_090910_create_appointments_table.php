<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->char('id_appointments', 9)->primary();
            $table->char('id_schedule', 9);
            $table->char('id_user', 9);
            $table->date('appointment_date');
            $table->integer('queue_number');
            $table->char('status', 1);
            $table->timestamps();

            $table->foreign('id_schedule')->references('id_schedule')->on('doctor_schedules')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
