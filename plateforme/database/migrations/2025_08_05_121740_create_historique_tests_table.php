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
       Schema::create('historique_tests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('test_type'); // TCF, TEF, DELF, etc.
        $table->string('skill');     // comprehension_ecrite, expression_orale, etc.
        $table->integer('score')->nullable();
        $table->string('niveau')->nullable(); // A1, B2, etc.
        $table->integer('duration')->nullable(); // en minutes
        $table->timestamp('completed_at')->nullable();
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historique_tests');
    }
};
