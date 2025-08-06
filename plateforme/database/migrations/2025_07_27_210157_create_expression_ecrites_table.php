<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpressionEcritesTable extends Migration
{
    public function up()
    {
        Schema::create('expression_ecrites', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_tache'); // 1, 2, 3
            $table->text('contexte_texte');
            $table->text('consigne');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expression_ecrites');
    }
}
