<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comprehension_ecrite', function (Blueprint $table) {
            $table->id();
            $table->integer('numero'); // Question 1 à 39
            $table->text('situation'); // Énoncé principal
            $table->text('question'); // Question posée
            $table->json('propositions'); // ['A', 'B', 'C', 'D']
            $table->string('reponse', 1); // A, B, C ou D
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comprehension_ecrite');
    }
};