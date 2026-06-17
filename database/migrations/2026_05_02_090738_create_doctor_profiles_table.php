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
        Schema::create('doctor_profiles', function (Blueprint $table) {
            $table->char('id_doctor', 9)->primary();
            $table->char('id_polis', 9);
            $table->char('id_user', 9);
            $table->string('sip_number', 50);
            $table->timestamps();

            // Relasi ke tabel polis dan users
            $table->foreign('id_polis')->references('id_polis')->on('polis')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profiles');
    }
};
