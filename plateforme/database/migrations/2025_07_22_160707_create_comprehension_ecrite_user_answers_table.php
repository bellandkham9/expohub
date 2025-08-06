<?php

// database/migrations/xxxx_xx_xx_create_expression_ecrite_user_answers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('comprehension_ecrite_user_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained('expression_ecrite')->onDelete('cascade');
            $table->string('reponse'); // réponse donnée (A, B, C, D)
            $table->string('test_type');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

     public function down()
    {
        Schema::table('comprehension_ecrite_user_answers', function (Blueprint $table) {
            $table->dropColumn('est_correcte');
        });
    }
};
