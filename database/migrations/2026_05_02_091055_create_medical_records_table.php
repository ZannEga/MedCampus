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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->char('id_med_records', 9)->primary();
            $table->char('id_appointments', 9);
            $table->text('diagnosis');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('id_appointments')->references('id_appointments')->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
