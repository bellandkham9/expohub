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
    Schema::table('expression_orales', function (Blueprint $table) {
        $table->string('skill')->after('type')->nullable();
    });
}

public function down()
{
    Schema::table('expression_orales', function (Blueprint $table) {
        $table->dropColumn('skill');
    });
}

};
