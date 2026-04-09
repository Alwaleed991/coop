<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // NOTE THIS HOW TO EVOLVE YOUR MIGRATION, YOU CREATE MIGRATIONS ON TOP
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->softDeletes(); // is exactly the same as $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
