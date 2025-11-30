<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comprehension_ecrite_resultats', function (Blueprint $table) {
            // ✅ On ajoute la colonne abonnement_id
            $table->foreignId('abonnement_id')
                  ->nullable() // ← au cas où tu as déjà des données, ça évite les erreurs
                  ->after('user_id')
                  ->constrained('abonnements')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('comprehension_ecrite_resultats', function (Blueprint $table) {
            $table->dropForeign(['abonnement_id']);
            $table->dropColumn('abonnement_id');
        });
    }
};
