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
        Schema::create('rekap_transports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('tahun');
            $table->string('bulan');
            $table->date('tanggal');
            $table->integer('hadir');
            $table->integer('transport');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_transports');
    }
};
