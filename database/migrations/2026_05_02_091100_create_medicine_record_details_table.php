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
        Schema::create('medicines_record_medicine', function (Blueprint $table) {
            $table->char('id_med_record_medicines', 9)->primary();
            $table->char('id_med', 9);
            $table->char('id_med_records', 9);
            $table->integer('quantity');
            $table->string('dosage', 100);
            $table->timestamps();

            $table->foreign('id_med')->references('id_med')->on('medicines')->onDelete('cascade');
            $table->foreign('id_med_records')->references('id_med_records')->on('medical_records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_record_details');
    }
};
