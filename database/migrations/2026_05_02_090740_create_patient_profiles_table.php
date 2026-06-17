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
        Schema::create('patient_profiles', function (Blueprint $table) {
            $table->char('id_patient', 9)->primary();
            $table->char('id_user', 9);
            $table->string('nim_nip', 50);
            $table->date('date_of_birth');
            $table->char('gender', 1); // Cukup 1 huruf: 'M' atau 'F'
            $table->text('address');
            $table->string('blood_type', 5);
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_profiles');
    }
};
