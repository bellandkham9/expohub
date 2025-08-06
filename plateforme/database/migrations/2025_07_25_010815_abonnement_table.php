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
        //
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->string('nom_du_plan'); // ex: TCF, DELF, DALF
            $table->string('examen'); // ex: Basique, Premium
            $table->float('prix'); // prix du plan
            $table->integer('duree'); // durée en jours (ex : 30 ou 365)
            $table->text('description')->nullable(); // description du plan
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
        Schema::dropIfExists('abonnements');
    }
};
