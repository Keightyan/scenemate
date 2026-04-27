<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cameraman_profiles', function (Blueprint $table) {
            $table->string('instagram_account', 100)->nullable()->after('portfolio_url');
        });

        Schema::table('model_profiles', function (Blueprint $table) {
            $table->string('instagram_account', 100)->nullable()->after('portfolio_url');
        });
    }

    public function down(): void
    {
        Schema::table('cameraman_profiles', function (Blueprint $table) {
            $table->dropColumn('instagram_account');
        });
        Schema::table('model_profiles', function (Blueprint $table) {
            $table->dropColumn('instagram_account');
        });
    }
};
