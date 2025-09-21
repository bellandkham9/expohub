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
    Schema::table('expression_orale_reponses', function (Blueprint $table) {
        $table->foreignId('abonnement_id')->nullable()->after('test_type')->constrained('abonnements');
    });
}

public function down(): void
{
    Schema::table('expression_orale_reponses', function (Blueprint $table) {
        $table->dropForeign(['abonnement_id']);
        $table->dropColumn('abonnement_id');
    });
}

};
