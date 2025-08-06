<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('expression_orale_reponses', function (Blueprint $table) {
            $table->string('test_type')->nullable()->after('score');
        });
    }

    public function down(): void
    {
        Schema::table('expression_orale_reponses', function (Blueprint $table) {
            $table->dropColumn('test_type');
        });
    }
};

