<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary(); // ID en UUID
            $table->string('type'); // Classe de la notification
            $table->morphs('notifiable'); // notifiable_id + notifiable_type
            $table->text('data'); // Données JSON
            $table->timestamp('read_at')->nullable(); // Marquage comme lu
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
