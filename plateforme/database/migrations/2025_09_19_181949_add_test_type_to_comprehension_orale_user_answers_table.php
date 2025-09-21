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
    Schema::table('comprehension_orale_user_answers', function (Blueprint $table) {
        $table->string('test_type')->nullable()->after('score');
    });
}

public function down()
{
    Schema::table('comprehension_orale_user_answers', function (Blueprint $table) {
        $table->dropColumn('test_type');
    });
}

};
