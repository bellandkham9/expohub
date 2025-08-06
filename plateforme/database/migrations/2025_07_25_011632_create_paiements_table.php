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
         Schema::create('paiements', function (Blueprint $table) {
            $table->id(); // ID auto-incrémenté

            $table->unsignedBigInteger('user_id'); // ID de l'utilisateur qui paie
            $table->unsignedBigInteger('abonnement_id')->nullable(); // ID de l'abonnement concerné (facultatif)

            $table->decimal('montant', 10, 2); // Montant payé avec 2 décimales
            $table->string('methode'); // Méthode utilisée (cinetpay, orange_money, etc.)
            $table->string('transaction_id')->unique(); // ID unique de la transaction (provenant de CinetPay ou autre)
            $table->string('statut')->default('en_attente'); // Statut du paiement : en_attente, réussi, échoué...
            $table->string('devise')->default('XAF'); // Devise utilisée (par défaut XAF)

            $table->text('details')->nullable(); // Détails complémentaires (JSON ou autres)

            $table->timestamps(); // Champs created_at et updated_at

            // Clés étrangères
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('abonnement_id')->references('id')->on('abonnements')->onDelete('set null');
        });
    

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
