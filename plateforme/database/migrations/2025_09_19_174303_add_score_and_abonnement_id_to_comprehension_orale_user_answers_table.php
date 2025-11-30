<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comprehension_orale_user_answers', function (Blueprint $table) {
            // Ajouter uniquement la colonne score si elle n'existe pas
            if (!Schema::hasColumn('comprehension_orale_user_answers', 'score')) {
                $table->integer('score')->default(0)->after('is_correct');
            }
        });
    }

    public function down(): void
    {
        Schema::table('comprehension_orale_user_answers', function (Blueprint $table) {
            $table->dropColumn('score');
        });
    }
};
