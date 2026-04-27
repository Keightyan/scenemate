<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_a_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('user_b_id')->constrained('users')->cascadeOnDelete();
            $table->timestamp('user_a_last_read_at')->nullable();
            $table->timestamp('user_b_last_read_at')->nullable();
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();

            $table->unique(['post_id', 'user_a_id', 'user_b_id']);
            $table->index('last_message_at');
            $table->index('user_a_id');
            $table->index('user_b_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
