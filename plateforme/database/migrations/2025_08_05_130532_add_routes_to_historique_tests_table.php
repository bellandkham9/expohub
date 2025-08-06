<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('historique_tests', function (Blueprint $table) {
        $table->string('details_route')->nullable()->after('completed_at');
        $table->string('refaire_route')->nullable()->after('details_route');
    });
}

public function down()
{
    Schema::table('historique_tests', function (Blueprint $table) {
        $table->dropColumn('details_route');
        $table->dropColumn('refaire_route');
    });
}
};
