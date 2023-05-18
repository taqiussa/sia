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
        Schema::create('penilaian_proyeks', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 30);
            $table->foreignId('proyek_id');
            $table->foreignId('kelas_id');
            $table->foreignId('nis');
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_proyeks');
    }
};
