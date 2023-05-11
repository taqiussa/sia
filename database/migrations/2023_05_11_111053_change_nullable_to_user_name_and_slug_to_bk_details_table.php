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
        Schema::table('bk_details', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
            $table->string('user_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bk_details', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('user_name');
        });
    }
};
