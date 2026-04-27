<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_user_id')->constrained('users')->cascadeOnDelete();
            $table->enum('owner_role', ['photographer', 'model']);
            $table->enum('target_role', ['photographer', 'model']);
            $table->enum('target_gender', ['female', 'male', 'other', 'any'])->default('any');
            $table->tinyInteger('target_age_min')->unsigned()->nullable();
            $table->tinyInteger('target_age_max')->unsigned()->nullable();
            $table->string('title', 150);
            $table->text('description')->nullable();
            $table->string('location_prefecture', 20)->nullable();
            $table->string('location_detail')->nullable();
            $table->string('date_note')->nullable();
            $table->string('reward_note')->nullable();
            $table->boolean('is_open')->default(true);
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->index('owner_user_id');
            $table->index('target_role');
            $table->index('target_gender');
            $table->index('location_prefecture');
            $table->index('is_open');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
