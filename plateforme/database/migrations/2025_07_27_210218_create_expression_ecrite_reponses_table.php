<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressionEcriteReponsesTable extends Migration
{
    public function up()
    {
        Schema::create('expression_ecrite_reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('expression_ecrite_id')->constrained()->onDelete('cascade');
            $table->text('reponse');                // réponse de l'élève
            $table->text('prompt')->nullable(); // 👈 Réponse de l'IA (feedback ou suite)
            $table->float('score')->nullable();     // score IA
            $table->text('commentaire')->nullable();// feedback IA
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expression_ecrite_reponses');
    }
}
