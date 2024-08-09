<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->enum("locale", ['en', 'ar', 'he'])->default("en");
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->enum("locale", ['en', 'ar', 'he'])->default("en");
        });

        Schema::table('landing_items', function (Blueprint $table) {
            $table->enum("locale", ['en', 'ar', 'he'])->default("en");
        });

        Schema::table('admins', function (Blueprint $table) {
            $table->enum("status", ["active", "inactive", "restrict", "close"])->nullable()->default("active");
            $table->timestamp("otp_expire")->nullable();
            $table->unsignedSmallInteger("otp_wrong_count")->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
