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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('password');
            $table->string('email_verification_token')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_prefix')->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('phone_verification_token')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->enum('role', ['SuperAdmin', 'Admin', 'Teacher'])->default('Teacher');
            $table->smallInteger('activated')->default(0);
            
            $table->string('first_name')->default('');
            $table->string('last_name')->default('');
            $table->string('stripe_api_key')->default('');
            $table->string('avatar')->default('');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
