<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('model_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->cascadeOnDelete();
            $table->smallInteger('height_cm')->nullable();
            $table->text('style_tags')->nullable();
            $table->enum('experience_level', ['beginner', 'intermediate', 'pro'])->nullable();
            $table->text('available_note')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_profiles');
    }
};
