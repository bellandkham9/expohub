<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comprehension_ecrite_user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained('comprehension_ecrite')->onDelete('cascade');
            $table->string('reponse'); // réponse donnée (A, B, C, D)
            $table->string('test_type', 100)->nullable(); // nom du type de test
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comprehension_ecrite_user_answers');
    }
};
