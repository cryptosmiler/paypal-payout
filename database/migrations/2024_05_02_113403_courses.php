<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin;
use App\Models\Subject;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class);
            $table->foreignIdFor(Subject::class);
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->string('coupon')->nullable();
            $table->enum('visible', ['show', 'hide'])->default("show");
            $table->enum('charge', ['free', 'pay'])->default("free");
            $table->string('video_price')->comment('cent')->default('100');
            $table->string('question_price')->comment('cent')->default('10');
            $table->timestamp('price_verified_at')->nullable();
            $table->enum('status', ['created', 'deleted']);
            $table->enum("locale", ['en', 'ar', 'he', ''])->default("en");
            $table->integer('order')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
