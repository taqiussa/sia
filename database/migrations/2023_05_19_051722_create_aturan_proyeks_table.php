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
        Schema::create('aturan_proyeks', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 30);
            $table->foreignId('proyek_id');
            $table->foreignId('dimensi_id');
            $table->foreignId('elemen_id');
            $table->foreignId('sub_elemen_id');
            $table->string('judul');
            $table->text('capaian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_proyeks');
    }
};
