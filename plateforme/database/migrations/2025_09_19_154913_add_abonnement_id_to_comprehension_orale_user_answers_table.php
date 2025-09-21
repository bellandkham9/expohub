<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comprehension_orale_user_answers', function (Blueprint $table) {
            $table->foreignId('abonnement_id')->nullable()->after('user_id')->constrained('abonnements')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('comprehension_orale_user_answers', function (Blueprint $table) {
            $table->dropForeign(['abonnement_id']);
            $table->dropColumn('abonnement_id');
        });
    }
};
