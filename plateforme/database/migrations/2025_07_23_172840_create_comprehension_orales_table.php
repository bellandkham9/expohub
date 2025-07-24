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
          Schema::create('comprehension_orales', function (Blueprint $table) {
            $table->id();
            $table->string('contexte_texte'); // texte ou chemin image
            $table->string('question_audio'); // chemin audio .mp3
            $table->string('proposition_1');
            $table->string('proposition_2');
            $table->string('proposition_3');
            $table->string('proposition_4');
            $table->string('bonne_reponse'); // "1", "2", "3" ou "4"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comprehension_orales');
    }
};
