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
        Schema::create('aturan_pulang_awals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('tahun', 30);
            $table->dateTime('masuk')->nullable();
            $table->dateTime('pulang')->nullable();
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_pulang_awals');
    }
};
