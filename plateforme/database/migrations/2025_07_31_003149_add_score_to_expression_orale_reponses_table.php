<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScoreToExpressionOraleReponsesTable extends Migration
{
    public function up()
    {
        Schema::table('expression_orale_reponses', function (Blueprint $table) {
            $table->integer('score')->default(0)->after('audio_ia'); // ou après la colonne que tu veux
        });
    }

    public function down()
    {
        Schema::table('expression_orale_reponses', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
}
