<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_message_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('chat_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('message_id')->constrained('chat_messages')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->dateTime('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_message_statuses');
    }
};
