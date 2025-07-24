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
        Schema::create('expression_ecrite_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('expression_ecrite_id')->constrained()->onDelete('cascade');
            $table->integer('note')->nullable(); // sur 20 par ex.
            $table->text('commentaire')->nullable(); // Feedback de l’IA
            $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expression_ecrite_scores');
    }
};
