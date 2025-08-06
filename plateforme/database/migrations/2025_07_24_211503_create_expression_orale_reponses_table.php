<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('expression_orale_reponses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('expression_orale_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('audio_eleve')->nullable();
        $table->string('audio_ia')->nullable();
        $table->text('texte_ia')->nullable();
        $table->text('transcription_eleve')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expression_orale_reponses');
    }
};
