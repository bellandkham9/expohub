<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('niveaux', function (Blueprint $table) {
        $table->id();

        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('test_type'); // Ex: 'tcf_canada', 'expression_orale'

        $table->string('niveau')->nullable(); // A1, A2, B1, B2, etc.
        $table->string('expression_ecrite')->nullable();
        $table->string('expression_orale')->nullable();
        $table->string('comprehension_ecrite')->nullable();
        $table->string('comprehension_orale')->nullable();

        $table->timestamps();

        $table->unique(['user_id', 'test_type']); // Un seul niveau par test et par utilisateur
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('niveaux');
    }
};
