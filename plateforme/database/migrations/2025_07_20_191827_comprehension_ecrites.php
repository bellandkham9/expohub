<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comprehension_ecrites', function (Blueprint $table) {
            $table->id();
            $table->text('contexte_texte')->nullable();
            $table->string('contexte_image')->nullable();
            $table->text('question');
            $table->string('proposition_1');
            $table->string('proposition_2');
            $table->string('proposition_3');
            $table->string('proposition_4');
            $table->tinyInteger('bonne_reponse');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprehension_ecrites');
    }
};

