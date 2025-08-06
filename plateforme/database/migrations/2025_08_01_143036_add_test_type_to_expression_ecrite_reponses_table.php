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
    Schema::table('expression_ecrite_reponses', function (Blueprint $table) {
        $table->unsignedBigInteger('test_type')->nullable()->after('user_id'); // ou after('id') selon ton besoin
    });
}

public function down()
{
    Schema::table('expression_ecrite_reponses', function (Blueprint $table) {
        $table->dropColumn('test_type');
    });
}

};
