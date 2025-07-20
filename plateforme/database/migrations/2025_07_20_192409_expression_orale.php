<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expression_orales', function (Blueprint $table) {
            $table->id();
            $table->text('contexte_texte');
            $table->text('consigne');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expression_orales');
    }
};

