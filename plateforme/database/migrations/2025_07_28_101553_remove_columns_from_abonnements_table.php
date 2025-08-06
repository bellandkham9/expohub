<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('abonnements', function (Blueprint $table) {
            //
        $table->dropColumn([
            'user_id',
            'date_debut',
            'date_fin',
            'type_dexamen',
            'statut',
            // Ajoute ici les autres colonnes à supprimer
        ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('abonnements', function (Blueprint $table) {
        $table->string('nom_du_plan')->nullable();
        $table->string('type_dexamen')->nullable();
        $table->decimal('prix', 10, 2)->nullable();
        $table->integer('duree'); 
        $table->text('description')->nullable(); // Description du plan (facultatif)

        
        // Ajoute ici les autres colonnes à restaurer
    });
    }
};
