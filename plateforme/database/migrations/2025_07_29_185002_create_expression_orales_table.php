<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressionOralesTable extends Migration
{
    public function up(): void
    {
        Schema::create('expression_orales', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // Exemple: 'tcf-canada', 'tcf-quebec'
            $table->unsignedTinyInteger('numero'); // Numéro de la tâche (1, 2 ou 3)
            $table->text('contexte')->nullable(); // Pour des infos contextuelles ou une situation
            $table->text('consigne'); // La consigne à suivre
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expression_orales');
    }
}
