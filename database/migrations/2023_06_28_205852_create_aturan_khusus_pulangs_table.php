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
        Schema::create('aturan_khusus_pulangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('tahun', 30);
            $table->string('semester', 3)->nullable();
            $table->integer('hari');
            $table->time('jam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aturan_khusus_pulangs');
    }
};
