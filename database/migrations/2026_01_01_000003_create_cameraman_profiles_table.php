<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cameraman_profiles', function (Blueprint $table) {
            $table->foreignId('user_id')->primary()->constrained()->cascadeOnDelete();
            $table->enum('experience_level', ['beginner', 'intermediate', 'pro'])->nullable();
            $table->text('equipment')->nullable();
            $table->text('genres')->nullable();
            $table->text('price_note')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->boolean('can_shoot_photo')->default(false);
            $table->boolean('can_shoot_video')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cameraman_profiles');
    }
};
