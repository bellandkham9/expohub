<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('expression_orales', function (Blueprint $table) {
            $table->string('consigne_audio')->nullable()->after('consigne');
        });
    }

    public function down(): void
    {
        Schema::table('expression_orales', function (Blueprint $table) {
            $table->dropColumn('consigne_audio');
        });
    }
};
